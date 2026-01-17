<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextEntry::make('name')
                ->label('Category Name'),

            TextEntry::make('expected_amount')
                ->label('Expected Monthly Amount')
                ->money('USD'),

            TextEntry::make('created_at')
                ->label('Created At')
                ->dateTime(),
        ]);
    }
}
