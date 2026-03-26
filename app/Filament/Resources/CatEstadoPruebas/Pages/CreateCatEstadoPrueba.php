<?php

namespace App\Filament\Resources\CatEstadoPruebas\Pages;

use App\Filament\Resources\CatEstadoPruebas\CatEstadoPruebaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatEstadoPrueba extends CreateRecord
{
    protected static string $resource = CatEstadoPruebaResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Catálogo de Estado de Pruebas';
}
