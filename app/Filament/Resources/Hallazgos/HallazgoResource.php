<?php

namespace App\Filament\Resources\Hallazgos;

use App\Filament\Resources\Hallazgos\Pages\CreateHallazgo;
use App\Filament\Resources\Hallazgos\Pages\EditHallazgo;
use App\Filament\Resources\Hallazgos\Pages\ListHallazgos;
use App\Filament\Resources\Hallazgos\Schemas\HallazgoForm;
use App\Filament\Resources\Hallazgos\Tables\HallazgosTable;
use App\Models\Hallazgo;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HallazgoResource extends Resource
{
    // Definimos el modelo
    protected static ?string $model = Hallazgo::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos el megáfono para representar las alertas o hallazgos encontrados
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    // --- CONFIGURACIÓN DE MENÚ PROFESIONAL ---
    
    protected static ?string $navigationLabel = 'Hallazgos de Usabilidad';
    
    protected static ?string $modelLabel = 'Hallazgo';
    
    protected static ?string $pluralModelLabel = 'Hallazgos';

    // Orden 6: El paso final después de observar a los participantes
    protected static ?int $navigationSort = 6;

    // ------------------------------------------

    public static function form(Schema $schema): Schema
    {
        return HallazgoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HallazgosTable::configure($table);
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
            'index' => ListHallazgos::route('/'),
            'create' => CreateHallazgo::route('/create'),
            'edit' => EditHallazgo::route('/{record}/edit'),
        ];
    }
}