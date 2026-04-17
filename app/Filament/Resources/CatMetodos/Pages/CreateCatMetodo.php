<?php

namespace App\Filament\Resources\CatMetodos\Pages;

use App\Filament\Resources\CatMetodos\CatMetodoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatMetodo extends CreateRecord
{
    protected static string $resource = CatMetodoResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Método';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
