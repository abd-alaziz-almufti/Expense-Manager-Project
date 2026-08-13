<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BudgetAlerts extends StatsOverviewWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $overBudgetCategories = Category::where('user_id', auth()->id())
            ->get()
            ->filter(fn($category) => $category->isOverBudget());

        if ($overBudgetCategories->isEmpty()) {
            return [
                Stat::make('حالة الميزانية | Budget Status', 'جميع الفئات ضمن الميزانية السليمة 🎉')
                    ->description('ممتاز! مصاريفك تحت السيطرة | Expenses under control')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
            ];
        }

        return $overBudgetCategories->map(function ($category) {
            $overAmount = $category->spentThisMonth() - $category->expected_amount;

            return Stat::make(
                $category->name,
                'تجاوز بـ $' . number_format($overAmount, 2)
            )
                ->description('تم تجاوز الميزانية المحددة لهذا الشهر | Exceeded budget')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger');
        })->toArray();
    }
}






