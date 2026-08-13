<?php

namespace App\Filament\Resources\Budgets\Tables;

use App\Models\Expense;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BudgetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // شهر الميزانية
                TextColumn::make('month')
                    ->label('شهر الميزانية | Month')
                    ->badge()
                    ->color('indigo')
                    ->icon('heroicon-m-calendar')
                    ->date('F Y')
                    ->sortable(),

                // الدخل
                TextColumn::make('total_income')
                    ->label('إجمالي الدخل | Total Income')
                    ->money('USD')
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),

                // المصروفات (محسوبة)
                TextColumn::make('expenses')
                    ->label('المصروفات الفعلية | Total Expenses')
                    ->getStateUsing(
                        fn($record) =>
                        Expense::where('user_id', $record->user_id)
                            ->whereMonth('expense_date', $record->month->month)
                            ->whereYear('expense_date', $record->month->year)
                            ->sum('amount')
                    )
                    ->money('USD')
                    ->weight('bold')
                    ->color('danger'),

                // المتبقي
                TextColumn::make('remaining')
                    ->label('الرصيد المتبقي | Remaining')
                    ->getStateUsing(
                        fn($record) =>
                        $record->total_income -
                        Expense::where('user_id', $record->user_id)
                            ->whereMonth('expense_date', $record->month->month)
                            ->whereYear('expense_date', $record->month->year)
                            ->sum('amount')
                    )
                    ->money('USD')
                    ->badge()
                    ->color(fn($state) => $state >= 0 ? 'success' : 'danger')
                    ->icon(fn($state) => $state >= 0 ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle'),

                // تاريخ الإنشاء
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('لا توجد ميزانيات شهرية مسجلة')
            ->emptyStateDescription('قم بإنشاء خطة ميزانية شهرية لمتابعة نسبة الإنفاق مقابل الدخل.')
            ->emptyStateIcon('heroicon-o-scale')
            ->recordActions([
                EditAction::make()
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

