<?php

namespace App\Filament\Resources\CatSeveridads\Pages;

use App\Filament\Resources\CatSeveridads\CatSeveridadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatSeveridads extends ListRecords
{
    protected static string $resource = CatSeveridadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
