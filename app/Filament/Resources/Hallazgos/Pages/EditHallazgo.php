<?php

namespace App\Filament\Resources\Hallazgos\Pages;

use App\Filament\Resources\Hallazgos\HallazgoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHallazgo extends EditRecord
{
    protected static string $resource = HallazgoResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Hallazgo';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
