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
                    ->label('Category Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('expected_amount')
                    ->label('Expected Monthly Amount')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('spent')
                    ->label('Spent (This Month)')
                    ->getStateUsing(fn($record) => $record->monthlyExpenses())
                    ->money('USD'),
                TextColumn::make('remaining')
                    ->label('Remaining')
                    ->getStateUsing(fn($record) => $record->remainingAmount())
                    ->money('USD')
                    ->color(fn($state) => $state < 0 ? 'danger' : 'success'),

                TextColumn::make('created_at')
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
