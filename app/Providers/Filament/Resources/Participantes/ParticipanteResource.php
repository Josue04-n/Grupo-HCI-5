<?php

namespace App\Filament\Resources\Participantes;

use App\Filament\Resources\Participantes\Pages\CreateParticipante;
use App\Filament\Resources\Participantes\Pages\EditParticipante;
use App\Filament\Resources\Participantes\Pages\ListParticipantes;
use App\Filament\Resources\Participantes\Schemas\ParticipanteForm;
use App\Filament\Resources\Participantes\Tables\ParticipantesTable;
use App\Models\Participante;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParticipanteResource extends Resource
{
    // Definimos el modelo para que Filament sepa a dónde apuntar
    protected static ?string $model = Participante::class;

    // --- ICONO REPRESENTATIVO ---
    // Usamos el icono de grupo de personas
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    // --- CONFIGURACIÓN DE MENÚ ---
    
    // Label limpio
    protected static ?string $navigationLabel = 'Participantes';

    // Orden 5 (Para que sigan la secuencia lógica)
    protected static ?int $navigationSort = 5;

    // Nombres para los títulos y botones de la interfaz
    protected static ?string $pluralModelLabel = 'Participantes';
    protected static ?string $modelLabel = 'Participante';

    // ------------------------------------------

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