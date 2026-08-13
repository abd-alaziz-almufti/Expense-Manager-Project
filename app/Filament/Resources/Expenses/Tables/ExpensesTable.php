<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('الفئة | Category')
                    ->badge()
                    ->color('indigo')
                    ->icon('heroicon-m-tag')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('المبلغ | Amount')
                    ->money('USD')
                    ->sortable()
                    ->weight('bold')
                    ->color('danger'),

                TextColumn::make('expense_date')
                    ->label('التاريخ | Date')
                    ->date('d M Y')
                    ->icon('heroicon-m-calendar')
                    ->sortable(),

                TextColumn::make('note')
                    ->label('ملاحظات | Note')
                    ->limit(35)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('لا توجد مصاريف مسجلة حتى الآن')
            ->emptyStateDescription('قم بإضافة مصاريفك اليومية للبدء في تحليل نفقاتك ومراقبة الميزانية.')
            ->emptyStateIcon('heroicon-o-credit-card')
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

