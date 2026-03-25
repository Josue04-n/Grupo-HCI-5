<?php

namespace App\Filament\Resources\Tareas;

use App\Filament\Resources\Tareas\Pages\CreateTarea;
use App\Filament\Resources\Tareas\Pages\EditTarea;
use App\Filament\Resources\Tareas\Pages\ListTareas;
use App\Filament\Resources\Tareas\Schemas\TareaForm;
use App\Filament\Resources\Tareas\Tables\TareasTable;
use App\Models\Tarea;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TareaResource extends Resource
{
    protected static ?string $model = Tarea::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos una lista de tareas (ListBullet)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    // --- CONFIGURACIÓN DE MENÚ ---
    
    // Nombre en el menú
    protected static ?string $navigationLabel = 'Tareas del Plan';

    // Orden 2 (Justo debajo de Planes de Prueba que es 1)
    protected static ?int $navigationSort = 2;

    // Nombres para los títulos y botones
    protected static ?string $pluralModelLabel = 'Tareas';
    protected static ?string $modelLabel = 'Tarea';

    // ------------------------------------------

    protected static ?string $recordTitleAttribute = 'codigo';

    public static function form(Schema $schema): Schema
    {
        return TareaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TareasTable::configure($table);
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
            'index' => ListTareas::route('/'),
            'create' => CreateTarea::route('/create'),
            'edit' => EditTarea::route('/{record}/edit'),
        ];
    }
}