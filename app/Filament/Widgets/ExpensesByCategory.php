<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use DB;
use Filament\Widgets\ChartWidget;

class ExpensesByCategory extends ChartWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    protected ?string $heading = 'Expenses By Category (Current Month)';

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

        return [
            'datasets' => [
                [
                    'label' => 'Expenses',
                    'data' => $data->pluck('total')->toArray(),
                ],
            ],
            'labels' => $data->pluck('category')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
