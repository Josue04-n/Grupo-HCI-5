<?php

namespace App\Filament\Resources\Sesions\Pages;

use App\Filament\Resources\Sesions\SesionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSesion extends EditRecord
{
    protected static string $resource = SesionResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Sesión';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
