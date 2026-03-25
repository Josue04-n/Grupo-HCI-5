<?php

namespace App\Filament\Resources\PruebaUsabilidads\Pages;

use App\Filament\Resources\PruebaUsabilidads\PruebaUsabilidadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPruebaUsabilidad extends EditRecord
{
    protected static string $resource = PruebaUsabilidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
