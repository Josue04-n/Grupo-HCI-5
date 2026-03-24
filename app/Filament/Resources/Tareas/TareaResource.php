<?php

namespace App\Filament\Resources\Tareas;

use App\Filament\Resources\Tareas\Pages\CreateTarea;
use App\Filament\Resources\Tareas\Pages\EditTarea;
use App\Filament\Resources\Tareas\Pages\ListTareas;
use App\Filament\Resources\Tareas\Schemas\TareaForm;
use App\Filament\Resources\Tareas\Tables\TareasTable;
use App\Models\Tarea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TareaResource extends Resource
{
    protected static ?string $model = Tarea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
