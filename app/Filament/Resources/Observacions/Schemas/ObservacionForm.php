<?php

namespace App\Filament\Resources\Observacions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ObservacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sesion_id')
                    ->required()
                    ->numeric(),
                TextInput::make('severidad_id')
                    ->numeric()
                    ->default(null),
                Select::make('exito')
                    ->options([
            'Sí, sin ayuda' => 'Sí, sin ayuda',
            'Sí, con poca ayuda' => 'Sí, con poca ayuda',
            'Sí, con mucha ayuda' => 'Sí, con mucha ayuda',
            'No completó' => 'No completó',
        ])
                    ->default(null),
                TextInput::make('eficacia')
                    ->numeric()
                    ->default(null),
                TextInput::make('eficiencia')
                    ->numeric()
                    ->default(null),
                TextInput::make('satisfaccion')
                    ->numeric()
                    ->default(null),
                TextInput::make('tiempo_seg')
                    ->numeric()
                    ->default(null),
                TextInput::make('errores')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('comentarios')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('problema_detectado')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('mejora_propuesta')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
