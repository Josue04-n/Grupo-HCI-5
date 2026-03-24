<?php

namespace App\Filament\Resources\CatEstadoHallazgos;

use App\Filament\Resources\CatEstadoHallazgos\Pages\CreateCatEstadoHallazgo;
use App\Filament\Resources\CatEstadoHallazgos\Pages\EditCatEstadoHallazgo;
use App\Filament\Resources\CatEstadoHallazgos\Pages\ListCatEstadoHallazgos;
use App\Filament\Resources\CatEstadoHallazgos\Schemas\CatEstadoHallazgoForm;
use App\Filament\Resources\CatEstadoHallazgos\Tables\CatEstadoHallazgosTable;
use App\Models\CatEstadoHallazgo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatEstadoHallazgoResource extends Resource
{
    protected static ?string $model = CatEstadoHallazgo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatEstadoHallazgoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatEstadoHallazgosTable::configure($table);
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
            'index' => ListCatEstadoHallazgos::route('/'),
            'create' => CreateCatEstadoHallazgo::route('/create'),
            'edit' => EditCatEstadoHallazgo::route('/{record}/edit'),
        ];
    }
}
