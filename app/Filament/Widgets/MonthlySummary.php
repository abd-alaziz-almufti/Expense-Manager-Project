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
                'Total Income',
                '$' . number_format($totalIncome, 2)
            ),

            Stat::make(
                'Total Expenses',
                '$' . number_format($totalExpenses, 2)
            ),

            Stat::make(
                'Remaining',
                '$' . number_format($remaining, 2)
            )->color($remaining >= 0 ? 'success' : 'danger'),
        ];
    }
}
