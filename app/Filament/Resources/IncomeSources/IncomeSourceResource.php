<?php

namespace App\Filament\Resources\IncomeSources;

use App\Filament\Resources\IncomeSources\Pages\CreateIncomeSource;
use App\Filament\Resources\IncomeSources\Pages\EditIncomeSource;
use App\Filament\Resources\IncomeSources\Pages\ListIncomeSources;
use App\Filament\Resources\IncomeSources\Pages\ViewIncomeSource;
use App\Filament\Resources\IncomeSources\Schemas\IncomeSourceForm;
use App\Filament\Resources\IncomeSources\Schemas\IncomeSourceInfolist;
use App\Filament\Resources\IncomeSources\Tables\IncomeSourcesTable;
use App\Models\IncomeSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class IncomeSourceResource extends Resource
{
    protected static ?string $model = IncomeSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static string|\UnitEnum|null $navigationGroup = 'إدارة المال | Financial Management';


    protected static ?string $navigationLabel = 'مصادر الدخل | Income Sources';

    protected static ?string $modelLabel = 'مصدر دخل | Income Source';

    protected static ?string $pluralModelLabel = 'مصادر الدخل | Income Sources';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return IncomeSourceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IncomeSourceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IncomeSourcesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomeSources::route('/'),
            'create' => CreateIncomeSource::route('/create'),
            'view' => ViewIncomeSource::route('/{record}'),
            'edit' => EditIncomeSource::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }
}

