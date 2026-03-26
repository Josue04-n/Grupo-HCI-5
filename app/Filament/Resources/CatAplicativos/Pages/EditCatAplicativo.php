<?php

namespace App\Filament\Resources\CatAplicativos\Pages;

use App\Filament\Resources\CatAplicativos\CatAplicativoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatAplicativo extends EditRecord
{
    protected static string $resource = CatAplicativoResource::class;
    protected static ?string $breadcrumb = 'Edición';
    protected static ?string $title = 'Edición Aplicativos';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
