<?php

namespace App\Filament\Resources\Observacions\Pages;

use App\Filament\Resources\Observacions\ObservacionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateObservacion extends CreateRecord
{
    protected static string $resource = ObservacionResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Observación';
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
