<?php

namespace App\Filament\Resources\Participantes\Pages;

use App\Filament\Resources\Participantes\ParticipanteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateParticipante extends CreateRecord
{
    protected static string $resource = ParticipanteResource::class;
    protected static ?string $breadcrumb = 'Creación';
    protected static ?string $title = 'Creación Participante';
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
