<?php

namespace App\Filament\Resources\CatEstadoHallazgos\Pages;

use App\Filament\Resources\CatEstadoHallazgos\CatEstadoHallazgoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatEstadoHallazgo extends CreateRecord
{
    protected static string $resource = CatEstadoHallazgoResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Catálogo de Estado de Hallazgos';
}
