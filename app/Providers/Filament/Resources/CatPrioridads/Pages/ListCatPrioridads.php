<?php

namespace App\Filament\Resources\CatPrioridads\Pages;

use App\Filament\Resources\CatPrioridads\CatPrioridadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatPrioridads extends ListRecords
{
    protected static string $resource = CatPrioridadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
