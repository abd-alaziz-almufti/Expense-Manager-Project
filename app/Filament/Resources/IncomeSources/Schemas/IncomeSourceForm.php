<?php

namespace App\Filament\Resources\IncomeSources\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IncomeSourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('معلومات مصدر الدخل | Income Source Details')
                ->description('قم بتأكيد مصادر الدخل الشهرية لتقوم المنظومة بحساب الرصيد المتبقي بشكل دقيق.')
                ->icon('heroicon-o-currency-dollar')
                ->schema([
                    TextInput::make('name')
                        ->label('اسم مصدر الدخل | Source Name')
                        ->placeholder('مثال: الراتب الشهري، عمل حر...')
                        ->prefixIcon('heroicon-m-sparkles')
                        ->required(),

                    TextInput::make('amount')
                        ->label('المبلغ الشهري | Monthly Amount')
                        ->numeric()
                        ->prefix('$')
                        ->prefixIcon('heroicon-m-banknotes')
                        ->placeholder('0.00')
                        ->required(),
                ])
                ->columns(2),
        ]);
    }
}

