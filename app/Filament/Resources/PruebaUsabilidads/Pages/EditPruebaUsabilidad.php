<?php

namespace App\Filament\Resources\PruebaUsabilidads\Pages;

use App\Filament\Resources\PruebaUsabilidads\PruebaUsabilidadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPruebaUsabilidad extends EditRecord
{
    protected static string $resource = PruebaUsabilidadResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Prueba de Usabilidad';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
