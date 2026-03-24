<?php

namespace App\Filament\Resources\CatEstadoPruebas;

use App\Filament\Resources\CatEstadoPruebas\Pages\CreateCatEstadoPrueba;
use App\Filament\Resources\CatEstadoPruebas\Pages\EditCatEstadoPrueba;
use App\Filament\Resources\CatEstadoPruebas\Pages\ListCatEstadoPruebas;
use App\Filament\Resources\CatEstadoPruebas\Schemas\CatEstadoPruebaForm;
use App\Filament\Resources\CatEstadoPruebas\Tables\CatEstadoPruebasTable;
use App\Models\CatEstadoPrueba;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatEstadoPruebaResource extends Resource
{
    protected static ?string $model = CatEstadoPrueba::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
