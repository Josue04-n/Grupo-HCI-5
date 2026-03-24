<?php

namespace App\Filament\Resources\Participantes;

use App\Filament\Resources\Participantes\Pages\CreateParticipante;
use App\Filament\Resources\Participantes\Pages\EditParticipante;
use App\Filament\Resources\Participantes\Pages\ListParticipantes;
use App\Filament\Resources\Participantes\Schemas\ParticipanteForm;
use App\Filament\Resources\Participantes\Tables\ParticipantesTable;
use App\Models\Participante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParticipanteResource extends Resource
{
    protected static ?string $model = Participante::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'codigo';

    public static function form(Schema $schema): Schema
    {
        return ParticipanteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParticipantesTable::configure($table);
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
            'index' => ListParticipantes::route('/'),
            'create' => CreateParticipante::route('/create'),
            'edit' => EditParticipante::route('/{record}/edit'),
        ];
    }
}
