<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BudgetAlerts extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {
        $overBudgetCategories = Category::where('user_id', auth()->id())
            ->get()
            ->filter(fn($category) => $category->isOverBudget());

        if ($overBudgetCategories->isEmpty()) {
            return [
                Stat::make('Budget Status', 'All categories are within budget')
                    ->description('Great job managing your finances 🎉')
                    ->color('success'),
            ];
        }

        return $overBudgetCategories->map(function ($category) {
            $overAmount = $category->spentThisMonth() - $category->expected_amount;

            return Stat::make(
                $category->name,
                'Over by $' . number_format($overAmount, 2)
            )
                ->description('Budget exceeded this month')
                ->color('danger');
        })->toArray();
    }
}





