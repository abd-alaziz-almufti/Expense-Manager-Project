<?php

namespace App\Filament\Resources\IncomeSources\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IncomeSourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Source Name')
                ->required(),

            TextInput::make('amount')
                ->numeric()
                ->label('Monthly Amount')
                ->required(),
        ]);
    }
}
