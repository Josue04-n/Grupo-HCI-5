<?php

namespace App\Filament\Resources\PruebaUsabilidads\Pages;

use App\Filament\Resources\PruebaUsabilidads\PruebaUsabilidadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPruebaUsabilidads extends ListRecords
{
    protected static string $resource = PruebaUsabilidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
