<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use App\Services\AiExpenseAdvisor;
use Illuminate\Support\HtmlString;
use App\Models\Category;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            // 🔹 زر النصائح
            Action::make('ai')
                ->label('Get AI Advice')
                ->icon('heroicon-o-sparkles')
                ->color('warning')
                ->modalHeading('AI Expense Advisor')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Close')
                ->modalContent(function () {
                    $advice = app(AiExpenseAdvisor::class)
                        ->analyze(auth()->id());

                    return new HtmlString(
                        nl2br(e($advice))
                    );
                }),

            // 🔹 زر تحسين الخطة
            Action::make('optimizeBudget')
                ->label('Optimize Monthly Budget with AI')
                ->icon('heroicon-o-cpu-chip')
                ->color('success')

                // 🧠 محتوى المودال (Before / After)
                ->modalHeading('AI Optimized Monthly Budget')
                ->modalContent(function () {
                    $service = app(AiExpenseAdvisor::class);
                    $plan = $service->optimizeBudget(auth()->id());

                    if (empty($plan)) {
                        return new HtmlString('<p>No optimized plan suggested.</p>');
                    }

                    $categories = Category::where('user_id', auth()->id())->get();

                    $rows = '';

                    foreach ($categories as $category) {
                        $old = $category->expected_amount;
                        $new = $plan[$category->name] ?? $old;

                        $changed = (float) $old !== (float) $new;

                        $rows .= "
                            <tr>
                                <td>{$category->name}</td>
                                <td>{$old} USD</td>
                                <td>
                                    {$new} USD
                                    " . ($changed ? '<span style="color:green;"> ✔</span>' : '') . "
                                </td>
                            </tr>
                        ";
                    }

                    return new HtmlString("
                        <table style='width:100%; border-collapse: collapse;' border='1' cellpadding='8'>
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Current Budget</th>
                                    <th>AI Suggested Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                {$rows}
                            </tbody>
                        </table>
                    ");
                })

                // ✅ زر Apply
                ->modalSubmitActionLabel('Apply AI Plan')
                ->action(function () {
                    $service = app(AiExpenseAdvisor::class);
                    $plan = $service->optimizeBudget(auth()->id());

                    $changes = 0;

                    foreach ($plan as $categoryName => $amount) {
                        $category = Category::where('user_id', auth()->id())
                            ->whereRaw('LOWER(name) = ?', [strtolower($categoryName)])
                            ->first();

                        if (!$category) {
                            continue;
                        }

                        if ((float) $category->expected_amount !== (float) $amount) {
                            $category->update([
                                'expected_amount' => $amount,
                            ]);
                            $changes++;
                        }
                    }

                    Notification::make()
                        ->title(
                            $changes > 0
                            ? "AI applied {$changes} budget improvements"
                            : "AI reviewed your budget and found it already optimized"
                        )
                        ->success()
                        ->send();
                }),

        ];
    }
}
