<?php

namespace App\Filament\Resources\IncomeSources\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IncomeSourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('مصدر الدخل | Source Name')
                    ->badge()
                    ->color('emerald')
                    ->icon('heroicon-m-sparkles')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('المبلغ الشهري | Monthly Amount')
                    ->money('USD')
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('لا توجد مصادر دخل مسجلة')
            ->emptyStateDescription('قم بإضافة مصادر دخلك (مثل الراتب، المشاريع، أو الاستثمارات) لحساب الميزانية المتبقية بشكل صحيح.')
            ->emptyStateIcon('heroicon-o-currency-dollar')
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-m-eye')
                    ->color('info'),
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

