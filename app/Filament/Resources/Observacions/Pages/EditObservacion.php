<?php

namespace App\Filament\Resources\Observacions\Pages;

use App\Filament\Resources\Observacions\ObservacionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditObservacion extends EditRecord
{
    protected static string $resource = ObservacionResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Observación';

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
