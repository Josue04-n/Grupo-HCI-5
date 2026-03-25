<?php

namespace App\Filament\Resources\CatPrioridads;

use App\Filament\Resources\CatPrioridads\Pages\CreateCatPrioridad;
use App\Filament\Resources\CatPrioridads\Pages\EditCatPrioridad;
use App\Filament\Resources\CatPrioridads\Pages\ListCatPrioridads;
use App\Filament\Resources\CatPrioridads\Schemas\CatPrioridadForm;
use App\Filament\Resources\CatPrioridads\Tables\CatPrioridadsTable;
use App\Models\CatPrioridad;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatPrioridadResource extends Resource
{
    protected static ?string $model = CatPrioridad::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;
    protected static UnitEnum|string|null $navigationGroup = 'Catálogos';
    protected static ?string $navigationLabel = 'Prioridades de Atención';
    protected static ?int $navigationSort = 14;
    protected static ?string $pluralModelLabel = 'Prioridades';
    protected static ?string $modelLabel = 'Prioridad';


    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatPrioridadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatPrioridadsTable::configure($table);
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
            'index' => ListCatPrioridads::route('/'),
            'create' => CreateCatPrioridad::route('/create'),
            'edit' => EditCatPrioridad::route('/{record}/edit'),
        ];
    }
}