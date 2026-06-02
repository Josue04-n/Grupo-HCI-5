<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\PruebaUsabilidad;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use App\Ai\Agents\SprintPlanner;
use Filament\Tables\Columns\TextColumn;

class AIBacklogQuickAccess extends BaseWidget
{
    protected static ?string $heading = 'Generación de Backlog con IA (Acceso Rápido)';
    
    protected static ?int $sort = 1; 

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PruebaUsabilidad::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('producto')
                    ->label('Producto')
                    ->searchable(),
                TextColumn::make('nombre')
                    ->label('Nombre de la Prueba')
                    ->description(fn (PruebaUsabilidad $record): string => $record->modulo ?? ''),
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date(),
                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Planificada' => 'info',
                        'En curso' => 'warning',
                        'Completada' => 'success',
                        'Cancelada' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Action::make('generateSprintBacklog')
                    ->label('Generar Backlog')
                    ->icon('heroicon-o-sparkles')
                    ->color('primary')
                    ->modalHeading('Borrador de Sprint Backlog Asistido por IA')
                    ->modalDescription('Analizando Plan, Guía y Hallazgos...')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->form([
                        MarkdownEditor::make('backlog_content')
                            ->label('Propuesta de Backlog')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->fillForm(fn ($record, SprintPlanner $agent) => [
                        'backlog_content' => $agent->generateDraft($record),
                    ])
                    ->extraModalFooterActions([
                        Action::make('exportMd')
                            ->label('Descargar .MD')
                            ->color('gray')
                            ->icon('heroicon-o-document-arrow-down')
                            ->action(function (array $data, $record) {
                                return response()->streamDownload(function () use ($data) {
                                    echo $data['backlog_content'];
                                }, "Sprint-Backlog-{$record->id}.md");
                            }),
                        Action::make('exportPdf')
                            ->label('Descargar .PDF')
                            ->color('danger')
                            ->icon('heroicon-o-document-text')
                            ->action(function (array $data, $record) {
                                return response()->streamDownload(function () use ($data, $record) {
                                    echo "SPRINT BACKLOG - UX TEST: {$record->producto}\n\n";
                                    echo $data['backlog_content'];
                                }, "Sprint-Backlog-{$record->id}.pdf");
                            }),
                    ]),
            ]);
    }
}
