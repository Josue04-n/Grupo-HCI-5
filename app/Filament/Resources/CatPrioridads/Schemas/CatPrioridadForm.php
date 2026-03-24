<?php

namespace App\Filament\Resources\CatPrioridads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CatPrioridadForm
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
