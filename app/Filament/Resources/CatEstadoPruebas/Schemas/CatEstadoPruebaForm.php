<?php

namespace App\Filament\Resources\CatEstadoPruebas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CatEstadoPruebaForm
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
