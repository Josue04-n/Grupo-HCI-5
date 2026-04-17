<?php

namespace App\Filament\Resources\Observacions\Pages;

use App\Filament\Resources\Observacions\ObservacionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListObservacions extends ListRecords
{
    protected static string $resource = ObservacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
