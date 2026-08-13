<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\IncomeSource;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlySummary extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = auth()->id();

        $totalIncome = IncomeSource::where('user_id', $userId)->sum('amount');

        $totalExpenses = Expense::where('user_id', $userId)
            ->currentMonth()
            ->sum('amount');

        $remaining = $totalIncome - $totalExpenses;

        return [
            Stat::make(
                'إجمالي الدخل | Total Income',
                '$' . number_format($totalIncome, 2)
            )
                ->description('مجموع مصادر الدخل | Registered Income')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make(
                'إجمالي المصاريف | Total Expenses',
                '$' . number_format($totalExpenses, 2)
            )
                ->description('مصاريف الشهر الحالي | Current Month')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make(
                'الرصيد المتبقي | Remaining Balance',
                '$' . number_format($remaining, 2)
            )
                ->description($remaining >= 0 ? 'وضع مالي متوازن | Healthy Budget' : 'تحذير: تجاوز الدخل | Deficit Warning')
                ->descriptionIcon($remaining >= 0 ? 'heroicon-m-wallet' : 'heroicon-m-exclamation-triangle')
                ->color($remaining >= 0 ? 'primary' : 'danger'),
        ];
    }
}

