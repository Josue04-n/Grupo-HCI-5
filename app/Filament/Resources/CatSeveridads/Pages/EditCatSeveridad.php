<?php

namespace App\Filament\Resources\CatSeveridads\Pages;

use App\Filament\Resources\CatSeveridads\CatSeveridadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatSeveridad extends EditRecord
{
    protected static string $resource = CatSeveridadResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Severidad';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
