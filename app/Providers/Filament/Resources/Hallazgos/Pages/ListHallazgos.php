<?php

namespace App\Filament\Resources\Hallazgos\Pages;

use App\Filament\Resources\Hallazgos\HallazgoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHallazgos extends ListRecords
{
    protected static string $resource = HallazgoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
