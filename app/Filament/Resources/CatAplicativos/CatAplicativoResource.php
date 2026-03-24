<?php

namespace App\Filament\Resources\CatAplicativos;

use App\Filament\Resources\CatAplicativos\Pages\CreateCatAplicativo;
use App\Filament\Resources\CatAplicativos\Pages\EditCatAplicativo;
use App\Filament\Resources\CatAplicativos\Pages\ListCatAplicativos;
use App\Filament\Resources\CatAplicativos\Schemas\CatAplicativoForm;
use App\Filament\Resources\CatAplicativos\Tables\CatAplicativosTable;
use App\Models\CatAplicativo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatAplicativoResource extends Resource
{
    protected static ?string $model = CatAplicativo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
