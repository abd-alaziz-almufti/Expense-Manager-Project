<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('category_id')
                ->label('Category')
                ->relationship(
                    name: 'category',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn($query) =>
                    $query->where('user_id', auth()->id())
                )
                ->required(),

            TextInput::make('amount')
                ->numeric()
                ->required(),

            DatePicker::make('expense_date')
                ->default(now())
                ->required(),

            Textarea::make('note')
                ->columnSpanFull(),
        ]);
    }
}
