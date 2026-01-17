<?php

namespace App\Filament\Resources\Budgets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            DatePicker::make('month')
                ->label('Month')
                ->required()
                ->displayFormat('F Y')
                ->native(false),

            TextInput::make('total_income')
                ->numeric()
                ->required(),
        ]);
    }
}
