<?php

namespace App\Filament\Resources\CatAplicativos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CatAplicativoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('url')
                    ->url()
                    ->default(null),
            ]);
    }
}
