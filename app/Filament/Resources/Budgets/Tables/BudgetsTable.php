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
                    ->label('Month')
                    ->date('F Y')
                    ->sortable(),

                // الدخل
                TextColumn::make('total_income')
                    ->label('Total Income')
                    ->money('USD')
                    ->sortable(),

                // المصروفات (محسوبة)
                TextColumn::make('expenses')
                    ->label('Total Expenses')
                    ->getStateUsing(
                        fn($record) =>
                        Expense::where('user_id', $record->user_id)
                            ->whereMonth('expense_date', $record->month->month)
                            ->whereYear('expense_date', $record->month->year)
                            ->sum('amount')
                    )
                    ->money('USD'),

                // المتبقي
                TextColumn::make('remaining')
                    ->label('Remaining')
                    ->getStateUsing(
                        fn($record) =>
                        $record->total_income -
                        Expense::where('user_id', $record->user_id)
                            ->whereMonth('expense_date', $record->month->month)
                            ->whereYear('expense_date', $record->month->year)
                            ->sum('amount')
                    )
                    ->money('USD')
                    ->color(fn($state) => $state >= 0 ? 'success' : 'danger'),

                //  تاريخ الإنشاء
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
