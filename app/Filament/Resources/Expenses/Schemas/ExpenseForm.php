<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('تفاصيل المصروف | Expense Details')
                ->description('أدخل معلومات المصروف بدقة لتحديث تقاريرك المالية تلقائياً.')
                ->icon('heroicon-o-credit-card')
                ->schema([
                    Select::make('category_id')
                        ->label('الفئة | Category')
                        ->relationship(
                            name: 'category',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn($query) =>
                            $query->where('user_id', auth()->id())
                        )
                        ->prefixIcon('heroicon-m-tag')
                        ->searchable()
                        ->preload()
                        ->required(),

                    TextInput::make('amount')
                        ->label('المبلغ | Amount')
                        ->numeric()
                        ->prefix('$')
                        ->prefixIcon('heroicon-m-currency-dollar')
                        ->placeholder('0.00')
                        ->required(),

                    DatePicker::make('expense_date')
                        ->label('تاريخ المصروف | Date')
                        ->prefixIcon('heroicon-m-calendar')
                        ->default(now())
                        ->native(false)
                        ->required(),

                    Textarea::make('note')
                        ->label('ملاحظات | Note')
                        ->placeholder('إضافة تفاصيل أو سبب المصروف...')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}

