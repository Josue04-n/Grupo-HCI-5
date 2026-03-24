<?php

namespace App\Filament\Resources\Sesions\Pages;

use App\Filament\Resources\Sesions\SesionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSesions extends ListRecords
{
    protected static string $resource = SesionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
