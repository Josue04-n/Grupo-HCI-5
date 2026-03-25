<?php

namespace App\Filament\Resources\Observacions;

use App\Filament\Resources\Observacions\Pages\CreateObservacion;
use App\Filament\Resources\Observacions\Pages\EditObservacion;
use App\Filament\Resources\Observacions\Pages\ListObservacions;
use App\Filament\Resources\Observacions\Schemas\ObservacionForm;
use App\Filament\Resources\Observacions\Tables\ObservacionsTable;
use App\Models\Observacion;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ObservacionResource extends Resource
{
    // NO OLVIDAR DEFINIR EL MODELO
    protected static ?string $model = Observacion::class;

    // --- ICONO REPRESENTATIVO ---
    // El icono de "Eye" (Ojo) es perfecto para observaciones
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEye;

    // --- CONFIGURACIÓN DE MENÚ PROFESIONAL ---
    
    // Usamos el tipado seguro que le gusta a tu Symfony
    protected static ?string $navigationLabel = 'Observaciones';
    
    protected static ?string $modelLabel = 'Observación';       
    
    protected static ?string $pluralModelLabel = 'Observaciones'; 

    // Orden 4: (Planes 1 -> Tareas 2 -> Sesiones 3 -> Observaciones 4)
    protected static ?int $navigationSort = 4; 

    // ------------------------------------------

    public static function form(Schema $schema): Schema
    {
        return ObservacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ObservacionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListObservacions::route('/'),
            'create' => CreateObservacion::route('/create'),
            'edit' => EditObservacion::route('/{record}/edit'),
        ];
    }
}