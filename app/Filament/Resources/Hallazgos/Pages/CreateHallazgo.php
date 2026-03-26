<?php

namespace App\Filament\Resources\Hallazgos\Pages;

use App\Filament\Resources\Hallazgos\HallazgoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHallazgo extends CreateRecord
{
    protected static string $resource = HallazgoResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Hallazgo';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
