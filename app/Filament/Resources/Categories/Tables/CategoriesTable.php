<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الفئة | Category Name')
                    ->badge()
                    ->color('indigo')
                    ->icon('heroicon-m-tag')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('expected_amount')
                    ->label('الميزانية المتوقعة | Expected Budget')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('spent')
                    ->label('المصروف الحالي | Spent This Month')
                    ->getStateUsing(fn($record) => $record->monthlyExpenses())
                    ->money('USD')
                    ->weight('bold')
                    ->color('danger'),

                TextColumn::make('remaining')
                    ->label('المتبقي | Remaining')
                    ->getStateUsing(fn($record) => $record->remainingAmount())
                    ->money('USD')
                    ->badge()
                    ->color(fn($state) => $state < 0 ? 'danger' : 'success')
                    ->icon(fn($state) => $state < 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle'),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('لا توجد فئات مسجلة حالياً')
            ->emptyStateDescription('قم بإنشاء فئات لتنظيم مصاريفك (مثل: سكن، مواصلات، فواتير) وتحديد ميزانية لكل منها.')
            ->emptyStateIcon('heroicon-o-tag')
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

