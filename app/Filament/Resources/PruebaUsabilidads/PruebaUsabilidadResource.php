<?php

namespace App\Filament\Resources\PruebaUsabilidads;

use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\PruebaUsabilidads\Pages\CreatePruebaUsabilidad;
use App\Filament\Resources\PruebaUsabilidads\Pages\EditPruebaUsabilidad;
use App\Filament\Resources\PruebaUsabilidads\Pages\ListPruebaUsabilidads;
use App\Filament\Resources\PruebaUsabilidads\Schemas\PruebaUsabilidadForm;
use App\Filament\Resources\PruebaUsabilidads\Tables\PruebaUsabilidadsTable;
use App\Models\PruebaUsabilidad;
use BackedEnum;
use UnitEnum; // Importante para el tipado
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PruebaUsabilidadResource extends Resource
{
    protected static ?string $model = PruebaUsabilidad::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos el matraz (Beaker) o una lupa sobre un documento para indicar "Prueba"
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    // --- CONFIGURACIÓN DE MENÚ PRINCIPAL ---

    // Este lo dejamos fuera de grupos para que sea el acceso directo principal
    protected static ?string $navigationLabel = 'Planes de Prueba';

    // Orden 1 para que sea lo primero que aparezca debajo de Dashboard
    protected static ?int $navigationSort = 1;

    // Corrección de etiquetas para títulos y botones
    protected static ?string $pluralModelLabel = 'Planes de Prueba';
    protected static ?string $modelLabel = 'Plan de Prueba';

    // ------------------------------------------

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return PruebaUsabilidadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PruebaUsabilidadsTable::configure($table);
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
            'index' => ListPruebaUsabilidads::route('/'),
            'create' => CreatePruebaUsabilidad::route('/create'),
            'edit' => EditPruebaUsabilidad::route('/{record}/edit'),
        ];
    }
}