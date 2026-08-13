<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('معلومات الفئة | Category Details')
                ->description('قم بتحديد فئات المصاريف والميزانية المتوقعة لكل فئة لتجنب الفائض.')
                ->icon('heroicon-o-tag')
                ->schema([
                    TextInput::make('name')
                        ->label('اسم الفئة | Category Name')
                        ->placeholder('مثال: الطعام، السكن، الترفيه...')
                        ->prefixIcon('heroicon-m-tag')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('expected_amount')
                        ->label('الميزانية الشهرية المتوقعة | Expected Monthly Budget')
                        ->numeric()
                        ->prefix('$')
                        ->prefixIcon('heroicon-m-calculator')
                        ->placeholder('0.00')
                        ->required(),
                ])
                ->columns(2),
        ]);
    }
}

