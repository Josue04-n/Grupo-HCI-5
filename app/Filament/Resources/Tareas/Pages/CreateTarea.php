<?php

namespace App\Filament\Resources\Tareas\Pages;

use App\Filament\Resources\Tareas\TareaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTarea extends CreateRecord
{
    protected static string $resource = TareaResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Tarea';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
