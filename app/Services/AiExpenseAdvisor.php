<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Category;
use OpenAI\Laravel\Facades\OpenAI;

class AiExpenseAdvisor
{
    public function analyze(int $userId): string
    {
        $expenses = Expense::where('user_id', $userId)
            ->currentMonth()
            ->with('category')
            ->get();

        if ($expenses->isEmpty()) {
            return 'No expenses recorded for this month yet.';
        }

        $total = $expenses->sum('amount');

        $byCategory = $expenses
            ->groupBy('category.name')
            ->map(fn($items) => $items->sum('amount'));

        $topCategory = $byCategory->sortDesc()->keys()->first();

        $categoryBudgetAnalysis = Category::where('user_id', $userId)
            ->get()
            ->map(function ($category) {
                $spent = $category->monthlyExpenses();
                $remaining = $category->remainingAmount();

                return "- {$category->name}:
                    Expected budget: {$category->expected_amount}
                    Spent this month: {$spent}
                    Remaining amount: {$remaining}";
            })
            ->implode("\n");

        $prompt = "
            You are a professional personal finance advisor.
            
            Important note:
            All monetary values below are expressed in United States Dollars (USD).
            
            The following is a summary of the user's expenses for the current month:
            
            - Total expenses (USD): {$total}
            - Highest spending category: {$topCategory}
            - Breakdown by category (USD):
            " . $byCategory->map(fn($amount, $category) => "- {$category}: {$amount} USD")->implode("\n") . "
            
            Category budget vs spending analysis (all amounts in USD):
            {$categoryBudgetAnalysis}
            
            Your task:
            1. Briefly analyze the spending behavior.
            2. Identify categories where spending exceeded the expected budget.
            3. Explain the remaining amount for each category in USD.
            4. Give 3 short, practical, and realistic tips to reduce expenses.
            5. Mention specific categories and dollar amounts when possible.
            6. Keep the tone friendly, supportive, and easy to understand.
            
            Respond in clear bullet points.
            ";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response->choices[0]->message->content;
    }

    public function optimizeBudget(int $userId): array
    {
        $categories = Category::where('user_id', $userId)->get();

        $categoryBudgetAnalysis = $categories
            ->map(function ($category) {
                $spent = $category->monthlyExpenses();
                $remaining = $category->remainingAmount();

                return "- {$category->name}:
                    Expected budget: {$category->expected_amount} USD
                    Spent this month: {$spent} USD
                    Remaining amount: {$remaining} USD";
            })
            ->implode("\n");

        $allowedCategories = $categories
            ->pluck('name')
            ->map(fn($name) => "- {$name}")
            ->implode("\n");

        $prompt = "
            You are a professional personal finance advisor.
            
            All monetary values are in USD.
            
            The user has a fixed total monthly budget distributed across categories.
            They also have actual spending data for the current month.
            
            Here is the category budget vs spending:
            
            {$categoryBudgetAnalysis}
            
            Your tasks:
            1. Analyze the spending behavior.
            2. Identify overspending and underspending categories.
            3. Propose a better monthly budget distribution.
            
            CRITICAL RULES:
            - The total sum of the new budget must remain the same as the current total budget.
            - Reduce budgets for overspending or non-essential categories.
            - Increase budgets for essential or underfunded categories.
            - Return ONLY valid JSON.
            - Do NOT include any explanations or text outside JSON.
            - Category names must match exactly.
            - Example:
            {\"Food\":250,\"Housing\":420,\"Entertainment\":150,\"Transport\":180}
            ";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $content = trim($response->choices[0]->message->content);

        // تنظيف Markdown
        $content = preg_replace('/```(json)?/i', '', $content);
        $content = trim($content);

        $plan = json_decode($content, true);

        if (!is_array($plan)) {
            \Log::error('AI budget optimization failed', [
                'response' => $content,
            ]);

            return [];
        }

        // تأكيد أن القيم أرقام
        return collect($plan)
            ->mapWithKeys(fn($amount, $category) => [
                $category => (float) $amount,
            ])
            ->toArray();
    }


}
