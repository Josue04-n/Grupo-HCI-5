<?php

namespace App\Filament\Resources\CatPrioridads\Pages;

use App\Filament\Resources\CatPrioridads\CatPrioridadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatPrioridad extends EditRecord
{
    protected static string $resource = CatPrioridadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
