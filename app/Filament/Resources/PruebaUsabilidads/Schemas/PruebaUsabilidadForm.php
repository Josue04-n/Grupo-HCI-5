<?php

namespace App\Filament\Resources\PruebaUsabilidads\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PruebaUsabilidadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('metodo_id')
                    ->required()
                    ->numeric(),
                TextInput::make('estado_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('producto')
                    ->required(),
                TextInput::make('modulo')
                    ->default(null),
                Textarea::make('objetivo')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('perfil_usuarios')
                    ->default(null)
                    ->columnSpanFull(),
                DatePicker::make('fecha'),
                TextInput::make('lugar')
                    ->default(null),
                TextInput::make('duracion')
                    ->default(null),
            ]);
    }
}
