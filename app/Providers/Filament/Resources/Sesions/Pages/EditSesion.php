<?php

namespace App\Filament\Resources\Sesions\Pages;

use App\Filament\Resources\Sesions\SesionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSesion extends EditRecord
{
    protected static string $resource = SesionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
