<?php

namespace App\Filament\Resources\Sesions\Pages;

use App\Filament\Resources\Sesions\SesionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSesion extends CreateRecord
{
    protected static string $resource = SesionResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Sesión';
}
