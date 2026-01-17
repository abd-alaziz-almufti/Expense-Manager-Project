<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Category Name')
                ->required()
                ->maxLength(255),

            TextInput::make('expected_amount')
                ->label('Expected Monthly Amount')
                ->numeric()
                ->required(),
        ]);
    }
}
