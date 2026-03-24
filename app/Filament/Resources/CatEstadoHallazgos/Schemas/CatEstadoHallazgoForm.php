<?php

namespace App\Filament\Resources\CatEstadoHallazgos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CatEstadoHallazgoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
            ]);
    }
}
