<?php

namespace App\Filament\Resources\CatSeveridads\Pages;

use App\Filament\Resources\CatSeveridads\CatSeveridadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatSeveridad extends CreateRecord
{
    protected static string $resource = CatSeveridadResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Severidad';

}
