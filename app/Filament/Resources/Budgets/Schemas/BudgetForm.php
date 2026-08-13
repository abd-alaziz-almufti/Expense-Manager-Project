<?php

namespace App\Filament\Resources\Budgets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('تفاصيل خطة الميزانية | Budget Plan Details')
                ->description('حدد الشهر المطلوب ومجموع الدخل المخصص لمقارنته بالنفقات الفعلية.')
                ->icon('heroicon-o-scale')
                ->schema([
                    DatePicker::make('month')
                        ->label('شهر الميزانية | Budget Month')
                        ->prefixIcon('heroicon-m-calendar')
                        ->required()
                        ->displayFormat('F Y')
                        ->native(false),

                    TextInput::make('total_income')
                        ->label('إجمالي الدخل المتوقع | Total Income')
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

