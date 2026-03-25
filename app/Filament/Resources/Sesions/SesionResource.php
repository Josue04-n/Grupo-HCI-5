<?php

namespace App\Filament\Resources\Sesions;

use App\Filament\Resources\Sesions\Pages\CreateSesion;
use App\Filament\Resources\Sesions\Pages\EditSesion;
use App\Filament\Resources\Sesions\Pages\ListSesions;
use App\Filament\Resources\Sesions\Schemas\SesionForm;
use App\Filament\Resources\Sesions\Tables\SesionsTable;
use App\Models\Sesion;
use BackedEnum;
use UnitEnum; // Importante para el tipado
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SesionResource extends Resource
{
    protected static ?string $model = Sesion::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos una cámara de video para representar las sesiones grabadas
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    // --- CONFIGURACIÓN DE MENÚ ---
    
    // Nombre limpio en el menú
    protected static ?string $navigationLabel = 'Sesiones de Prueba';

    // Orden 3 (Después de Planes [1] y Tareas [2])
    protected static ?int $navigationSort = 3;

    // Corrección de plurales y etiquetas
    protected static ?string $pluralModelLabel = 'Sesiones';
    protected static ?string $modelLabel = 'Sesión';

    // ------------------------------------------

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return SesionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SesionsTable::configure($table);
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
            'index' => ListSesions::route('/'),
            'create' => CreateSesion::route('/create'),
            'edit' => EditSesion::route('/{record}/edit'),
        ];
    }
}