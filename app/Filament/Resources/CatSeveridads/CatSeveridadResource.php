<?php

namespace App\Filament\Resources\CatSeveridads;

use App\Filament\Resources\CatSeveridads\Pages\CreateCatSeveridad;
use App\Filament\Resources\CatSeveridads\Pages\EditCatSeveridad;
use App\Filament\Resources\CatSeveridads\Pages\ListCatSeveridads;
use App\Filament\Resources\CatSeveridads\Schemas\CatSeveridadForm;
use App\Filament\Resources\CatSeveridads\Tables\CatSeveridadsTable;
use App\Models\CatSeveridad;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatSeveridadResource extends Resource
{
    protected static ?string $model = CatSeveridad::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatSeveridadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatSeveridadsTable::configure($table);
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
            'index' => ListCatSeveridads::route('/'),
            'create' => CreateCatSeveridad::route('/create'),
            'edit' => EditCatSeveridad::route('/{record}/edit'),
        ];
    }
}
