<?php

namespace App\Filament\Resources\Hallazgos\Pages;

use App\Filament\Resources\Hallazgos\HallazgoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHallazgo extends EditRecord
{
    protected static string $resource = HallazgoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
