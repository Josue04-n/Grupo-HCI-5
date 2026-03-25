<?php

namespace App\Filament\Resources\CatAplicativos;

use App\Filament\Resources\CatAplicativos\Pages\CreateCatAplicativo;
use App\Filament\Resources\CatAplicativos\Pages\EditCatAplicativo;
use App\Filament\Resources\CatAplicativos\Pages\ListCatAplicativos;
use App\Filament\Resources\CatAplicativos\Schemas\CatAplicativoForm;
use App\Filament\Resources\CatAplicativos\Tables\CatAplicativosTable;
use Filament\Support\Icons\Heroicon;
use App\Models\CatAplicativo;
use BackedEnum;
use UnitEnum; // Asegúrate de que esta línea esté aquí
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CatAplicativoResource extends Resource
{
    protected static ?string $model = CatAplicativo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;
    protected static UnitEnum|string|null $navigationGroup = 'Catálogos';
    protected static ?string $navigationLabel = 'Aplicativos';
    protected static ?int $navigationSort = 1;
    protected static ?string $pluralModelLabel = 'Aplicativos';
    protected static ?string $modelLabel = 'Aplicativo';
    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatAplicativoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatAplicativosTable::configure($table);
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
            'index' => ListCatAplicativos::route('/'),
            'create' => CreateCatAplicativo::route('/create'),
            'edit' => EditCatAplicativo::route('/{record}/edit'),
        ];
    }
}