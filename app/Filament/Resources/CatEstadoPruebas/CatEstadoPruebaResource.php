<?php

namespace App\Filament\Resources\CatEstadoPruebas;

use App\Filament\Resources\CatEstadoPruebas\Pages\CreateCatEstadoPrueba;
use App\Filament\Resources\CatEstadoPruebas\Pages\EditCatEstadoPrueba;
use App\Filament\Resources\CatEstadoPruebas\Pages\ListCatEstadoPruebas;
use App\Filament\Resources\CatEstadoPruebas\Schemas\CatEstadoPruebaForm;
use App\Filament\Resources\CatEstadoPruebas\Tables\CatEstadoPruebasTable;
use App\Models\CatEstadoPrueba;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatEstadoPruebaResource extends Resource
{
    protected static ?string $model = CatEstadoPrueba::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos un icono de portapapeles con check para indicar estados de proceso
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    // --- CONFIGURACIÓN DE MENÚ PROFESIONAL ---
    
    // Agrupado con los demás catálogos
    protected static UnitEnum|string|null $navigationGroup = 'Catálogos';

    // Etiqueta limpia en el menú
    protected static ?string $navigationLabel = 'Estados de Pruebas';

    // Orden dentro del grupo (12 para que siga la secuencia)
    protected static ?int $navigationSort = 12;

    // Nombres para los títulos y botones
    protected static ?string $pluralModelLabel = 'Estados de Pruebas';
    protected static ?string $modelLabel = 'Estado de Prueba';

    // ------------------------------------------

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatEstadoPruebaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatEstadoPruebasTable::configure($table);
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
            'index' => ListCatEstadoPruebas::route('/'),
            'create' => CreateCatEstadoPrueba::route('/create'),
            'edit' => EditCatEstadoPrueba::route('/{record}/edit'),
        ];
    }
}