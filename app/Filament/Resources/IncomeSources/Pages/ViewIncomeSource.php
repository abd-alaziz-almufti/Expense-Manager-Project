<?php

namespace App\Filament\Resources\IncomeSources\Pages;

use App\Filament\Resources\IncomeSources\IncomeSourceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIncomeSource extends ViewRecord
{
    protected static string $resource = IncomeSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
