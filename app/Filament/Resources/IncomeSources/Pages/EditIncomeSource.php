<?php

namespace App\Filament\Resources\IncomeSources\Pages;

use App\Filament\Resources\IncomeSources\IncomeSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditIncomeSource extends EditRecord
{
    protected static string $resource = IncomeSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
