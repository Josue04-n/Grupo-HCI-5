<?php

namespace App\Filament\Resources\CatMetodos;

use App\Filament\Resources\CatMetodos\Pages\CreateCatMetodo;
use App\Filament\Resources\CatMetodos\Pages\EditCatMetodo;
use App\Filament\Resources\CatMetodos\Pages\ListCatMetodos;
use App\Filament\Resources\CatMetodos\Schemas\CatMetodoForm;
use App\Filament\Resources\CatMetodos\Tables\CatMetodosTable;
use App\Models\CatMetodo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatMetodoResource extends Resource
{
    protected static ?string $model = CatMetodo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatMetodoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatMetodosTable::configure($table);
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
            'index' => ListCatMetodos::route('/'),
            'create' => CreateCatMetodo::route('/create'),
            'edit' => EditCatMetodo::route('/{record}/edit'),
        ];
    }
}
