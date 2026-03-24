<?php

namespace App\Filament\Resources\Observacions;

use App\Filament\Resources\Observacions\Pages\CreateObservacion;
use App\Filament\Resources\Observacions\Pages\EditObservacion;
use App\Filament\Resources\Observacions\Pages\ListObservacions;
use App\Filament\Resources\Observacions\Schemas\ObservacionForm;
use App\Filament\Resources\Observacions\Tables\ObservacionsTable;
use App\Models\Observacion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ObservacionResource extends Resource
{
    protected static ?string $model = Observacion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ObservacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ObservacionsTable::configure($table);
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
            'index' => ListObservacions::route('/'),
            'create' => CreateObservacion::route('/create'),
            'edit' => EditObservacion::route('/{record}/edit'),
        ];
    }
}
