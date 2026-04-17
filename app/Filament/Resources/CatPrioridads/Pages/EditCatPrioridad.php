<?php

namespace App\Filament\Resources\CatPrioridads\Pages;

use App\Filament\Resources\CatPrioridads\CatPrioridadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatPrioridad extends EditRecord
{
    protected static string $resource = CatPrioridadResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Prioridad';

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
