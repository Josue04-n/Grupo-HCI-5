<?php

namespace App\Filament\Resources\PruebaUsabilidads\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class PruebaUsabilidadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // 1. El User ID se llena solo con el usuario logueado
                Hidden::make('user_id')
                    ->default(auth()->id()),

                // 2. Selección de Método (Catálogo)
                Select::make('metodo_id')
                    ->label('Método de evaluación')
                    ->relationship('metodo', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload(),

                // 3. Selección de Estado (Catálogo)
                Select::make('estado_id')
                    ->label('Estado de la prueba')
                    ->relationship('estado', 'nombre')
                    ->required()
                    ->native(false),

                TextInput::make('nombre')
                    ->label('Nombre del Plan de Prueba')
                    ->required()
                    ->placeholder('Ej: Evaluación comparativa JEP vs Maquita'),

                TextInput::make('producto')
                    ->required(),

                TextInput::make('modulo')
                    ->label('Módulo/Sección evaluada'),

                Textarea::make('objetivo')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('perfil_usuarios')
                    ->label('Perfil de los Participantes')
                    ->columnSpanFull(),

                DatePicker::make('fecha')
                    ->native(false)
                    ->displayFormat('d/m/Y'),

                TextInput::make('lugar'),
                
                TextInput::make('duracion')
                    ->label('Duración estimada')
                    ->placeholder('Ej: 20-30 min'),
            ]);
    }
}