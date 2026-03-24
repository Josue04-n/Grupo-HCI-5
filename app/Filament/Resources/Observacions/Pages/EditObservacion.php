<?php

namespace App\Filament\Resources\Observacions\Pages;

use App\Filament\Resources\Observacions\ObservacionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditObservacion extends EditRecord
{
    protected static string $resource = ObservacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
