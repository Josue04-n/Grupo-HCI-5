<?php

namespace App\Filament\Resources\Participantes\Pages;

use App\Filament\Resources\Participantes\ParticipanteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParticipantes extends ListRecords
{
    protected static string $resource = ParticipanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
