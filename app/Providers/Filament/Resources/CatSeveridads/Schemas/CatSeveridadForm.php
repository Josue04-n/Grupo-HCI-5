<?php

namespace App\Filament\Resources\CatSeveridads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CatSeveridadForm
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
