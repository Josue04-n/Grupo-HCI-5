<?php

namespace App\Filament\Resources\CatMetodos\Pages;

use App\Filament\Resources\CatMetodos\CatMetodoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatMetodo extends EditRecord
{
    protected static string $resource = CatMetodoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
