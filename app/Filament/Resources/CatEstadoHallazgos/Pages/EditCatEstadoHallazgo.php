<?php

namespace App\Filament\Resources\CatEstadoHallazgos\Pages;

use App\Filament\Resources\CatEstadoHallazgos\CatEstadoHallazgoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatEstadoHallazgo extends EditRecord
{
    protected static string $resource = CatEstadoHallazgoResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Estado de Hallazgos';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
