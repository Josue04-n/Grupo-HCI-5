<?php

namespace App\Filament\Resources\CatPrioridads\Pages;

use App\Filament\Resources\CatPrioridads\CatPrioridadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatPrioridad extends CreateRecord
{
    protected static string $resource = CatPrioridadResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Prioridad';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
