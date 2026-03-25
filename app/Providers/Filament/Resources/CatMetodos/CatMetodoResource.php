<?php

namespace App\Filament\Resources\CatMetodos;

use App\Filament\Resources\CatMetodos\Pages\CreateCatMetodo;
use App\Filament\Resources\CatMetodos\Pages\EditCatMetodo;
use App\Filament\Resources\CatMetodos\Pages\ListCatMetodos;
use App\Filament\Resources\CatMetodos\Schemas\CatMetodoForm;
use App\Filament\Resources\CatMetodos\Tables\CatMetodosTable;
use App\Models\CatMetodo;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatMetodoResource extends Resource
{
    protected static ?string $model = CatMetodo::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos el frasco de laboratorio para representar la metodología de investigación
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    // --- CONFIGURACIÓN DE MENÚ PROFESIONAL ---
    
    // Agrupado con los demás catálogos
    protected static UnitEnum|string|null $navigationGroup = 'Catálogos';

    // Etiqueta limpia en el menú
    protected static ?string $navigationLabel = 'Métodos de Evaluación';

    // Orden dentro del grupo (13 para seguir la secuencia)
    protected static ?int $navigationSort = 13;

    // Nombres para los títulos y botones
    protected static ?string $pluralModelLabel = 'Métodos de Evaluación';
    protected static ?string $modelLabel = 'Método';

    // ------------------------------------------

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatMetodoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatMetodosTable::configure($table);
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
            'index' => ListCatMetodos::route('/'),
            'create' => CreateCatMetodo::route('/create'),
            'edit' => EditCatMetodo::route('/{record}/edit'),
        ];
    }
}