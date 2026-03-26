<?php

namespace App\Filament\Resources\CatAplicativos\Pages;

use App\Filament\Resources\CatAplicativos\CatAplicativoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatAplicativo extends CreateRecord
{
    protected static string $resource = CatAplicativoResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Catálogo de Aplicativos';
}
