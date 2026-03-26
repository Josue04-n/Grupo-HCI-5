<?php

namespace App\Filament\Resources\CatEstadoPruebas\Pages;

use App\Filament\Resources\CatEstadoPruebas\CatEstadoPruebaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatEstadoPrueba extends EditRecord
{
    protected static string $resource = CatEstadoPruebaResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Estado de Pruebas';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
