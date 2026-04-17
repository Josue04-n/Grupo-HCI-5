<?php

namespace App\Filament\Resources\CatMetodos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CatMetodoForm
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
