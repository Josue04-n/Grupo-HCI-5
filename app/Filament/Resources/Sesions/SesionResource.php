<?php

namespace App\Filament\Resources\Sesions;

use App\Filament\Resources\Sesions\Pages\CreateSesion;
use App\Filament\Resources\Sesions\Pages\EditSesion;
use App\Filament\Resources\Sesions\Pages\ListSesions;
use App\Filament\Resources\Sesions\Schemas\SesionForm;
use App\Filament\Resources\Sesions\Tables\SesionsTable;
use App\Models\Sesion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SesionResource extends Resource
{
    protected static ?string $model = Sesion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return SesionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SesionsTable::configure($table);
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
            'index' => ListSesions::route('/'),
            'create' => CreateSesion::route('/create'),
            'edit' => EditSesion::route('/{record}/edit'),
        ];
    }
}
