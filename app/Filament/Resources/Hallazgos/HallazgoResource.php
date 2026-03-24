<?php

namespace App\Filament\Resources\Hallazgos;

use App\Filament\Resources\Hallazgos\Pages\CreateHallazgo;
use App\Filament\Resources\Hallazgos\Pages\EditHallazgo;
use App\Filament\Resources\Hallazgos\Pages\ListHallazgos;
use App\Filament\Resources\Hallazgos\Schemas\HallazgoForm;
use App\Filament\Resources\Hallazgos\Tables\HallazgosTable;
use App\Models\Hallazgo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HallazgoResource extends Resource
{
    protected static ?string $model = Hallazgo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'problema';

    public static function form(Schema $schema): Schema
    {
        return HallazgoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HallazgosTable::configure($table);
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
            'index' => ListHallazgos::route('/'),
            'create' => CreateHallazgo::route('/create'),
            'edit' => EditHallazgo::route('/{record}/edit'),
        ];
    }
}
