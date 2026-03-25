<?php

namespace App\Filament\Resources\CatSeveridads;

use App\Filament\Resources\CatSeveridads\Pages\CreateCatSeveridad;
use App\Filament\Resources\CatSeveridads\Pages\EditCatSeveridad;
use App\Filament\Resources\CatSeveridads\Pages\ListCatSeveridads;
use App\Filament\Resources\CatSeveridads\Schemas\CatSeveridadForm;
use App\Filament\Resources\CatSeveridads\Tables\CatSeveridadsTable;
use App\Models\CatSeveridad;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatSeveridadResource extends Resource
{
    protected static ?string $model = CatSeveridad::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos un triángulo de advertencia para representar la severidad de los errores
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    // --- CONFIGURACIÓN DE MENÚ PROFESIONAL ---
    
    // Agrupado con los demás catálogos
    protected static UnitEnum|string|null $navigationGroup = 'Catálogos';

    // Corregimos el nombre que sale en el menú
    protected static ?string $navigationLabel = 'Niveles de Severidad';

    // Ordenamos (15 para ser el último del grupo)
    protected static ?int $navigationSort = 15;

    // Nombres para los títulos y botones
    protected static ?string $pluralModelLabel = 'Niveles de Severidad';
    protected static ?string $modelLabel = 'Nivel de Severidad';

    // ------------------------------------------

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatSeveridadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatSeveridadsTable::configure($table);
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
            'index' => ListCatSeveridads::route('/'),
            'create' => CreateCatSeveridad::route('/create'),
            'edit' => EditCatSeveridad::route('/{record}/edit'),
        ];
    }
}