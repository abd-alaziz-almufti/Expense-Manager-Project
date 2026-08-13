<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use DB;
use Filament\Widgets\ChartWidget;

class ExpensesByCategory extends ChartWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    protected ?string $heading = 'توزيع المصاريف حسب الفئة (الشهر الحالي) | Expenses By Category';

    protected function getData(): array
    {
        $userId = auth()->id();

        $data = Expense::query()
            ->where('expenses.user_id', $userId)
            ->currentMonth()
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category',
                DB::raw('SUM(expenses.amount) as total')
            )
            ->groupBy('categories.name')
            ->get();

        $colors = [
            '#6366f1', // Indigo
            '#10b981', // Emerald
            '#f59e0b', // Amber
            '#f43f5e', // Rose
            '#06b6d4', // Cyan
            '#8b5cf6', // Purple
            '#ec4899', // Pink
            '#3b82f6', // Blue
        ];

        return [
            'datasets' => [
                [
                    'label' => 'المصاريف ($)',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, max(count($data), 1)),
                    'borderWidth' => 2,
                    'hoverOffset' => 6,
                ],
            ],
            'labels' => $data->pluck('category')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

