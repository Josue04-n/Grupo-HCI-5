<?php

namespace App\Filament\Resources\CatMetodos\Pages;

use App\Filament\Resources\CatMetodos\CatMetodoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatMetodo extends EditRecord
{
    protected static string $resource = CatMetodoResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Método Evaluación';

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
