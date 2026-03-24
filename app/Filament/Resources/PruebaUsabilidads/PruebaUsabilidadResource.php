<?php

namespace App\Filament\Resources\PruebaUsabilidads;

use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\PruebaUsabilidads\Pages\CreatePruebaUsabilidad;
use App\Filament\Resources\PruebaUsabilidads\Pages\EditPruebaUsabilidad;
use App\Filament\Resources\PruebaUsabilidads\Pages\ListPruebaUsabilidads;
use App\Filament\Resources\PruebaUsabilidads\Schemas\PruebaUsabilidadForm;
use App\Filament\Resources\PruebaUsabilidads\Tables\PruebaUsabilidadsTable;
use App\Models\PruebaUsabilidad;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PruebaUsabilidadResource extends Resource
{
    protected static ?string $model = PruebaUsabilidad::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return PruebaUsabilidadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PruebaUsabilidadsTable::configure($table);
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
            'index' => ListPruebaUsabilidads::route('/'),
            'create' => CreatePruebaUsabilidad::route('/create'),
            'edit' => EditPruebaUsabilidad::route('/{record}/edit'),
        ];
    }
}
