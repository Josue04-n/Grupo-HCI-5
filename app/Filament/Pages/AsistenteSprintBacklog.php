<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use App\Models\PruebaUsabilidad;
use App\Models\CatAplicativo;
use App\Models\SprintBacklogHistory;
use App\Ai\Agents\SprintPlanner;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\HtmlString;
use BackedEnum;

class AsistenteSprintBacklog extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static ?string $navigationLabel = 'Asistente de Backlog IA';
    protected static ?string $title = 'Asistente de Sprint Backlog Asistido por IA';
    protected static ?string $slug = 'asistente-sprint-backlog';
    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.asistente-sprint-backlog';

    public ?array $data = [];
    public ?string $backlogContent = null;
    public ?array $backlogData = [];
    public ?string $feedbackMessage = null;
    public ?string $feedbackType = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('aplicativo_id')
                    ->label('Seleccionar Aplicativo / Proyecto')
                    ->placeholder('Elija el sistema analizado...')
                    ->options(CatAplicativo::pluck('nombre', 'id'))
                    ->required()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('version_id', null);
                        $this->resetBacklogDraft();
                    }),

                Select::make('version_id')
                    ->label('Cargar Historial (Opcional)')
                    ->placeholder('Seleccione un backlog guardado...')
                    ->helperText(fn (Get $get) => !$get('aplicativo_id') ? 'Seleccione primero un aplicativo para ver su historial.' : null)
                    ->options(function (Get $get) {
                        $aplicativoId = $get('aplicativo_id');
                        
                        if (!$aplicativoId) {
                            return [];
                        }

                        return SprintBacklogHistory::where('aplicativo_id', $aplicativoId)
                            ->latest()
                            ->get()
                            ->pluck('version_name', 'id');
                    })
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        if (!$state) return;
                        
                        $history = SprintBacklogHistory::find($state);
                        if ($history) {
                            $this->loadBacklogFromHistory($history->content);

                            Notification::make()
                                ->title('Versión cargada')
                                ->body('Se ha cargado el backlog desde el historial.')
                                ->success()
                                ->send();
                        }
                    }),
            ])
            ->statePath('data');
    }

    public function backlogForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                MarkdownEditor::make('backlogContent')
                    ->label('Edición del Backlog (Humano-en-el-bucle)')
                    ->helperText('Ajuste las historias de usuario y tareas técnicas propuestas por la IA.')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('backlogData');
    }

    protected function getForms(): array
    {
        return [
            'form',
            'backlogForm',
        ];
    }

    protected function resetBacklogDraft(): void
    {
        $this->backlogContent = null;
        $this->backlogData = [];
        $this->feedbackMessage = null;
        $this->feedbackType = null;
    }

    protected function loadBacklogFromHistory(string $content): void
    {
        $this->backlogContent = $content;
        $this->backlogData = [
            'backlogContent' => $content,
        ];
    }

    protected function getCurrentBacklogContent(): string
    {
        return (string) ($this->backlogData['backlogContent'] ?? $this->backlogContent ?? '');
    }

    public function generate(SprintPlanner $agent): void
    {
        $state = $this->form->getState();
        $this->feedbackMessage = 'Procesando el backlog con IA. Esto puede tardar unos segundos.';
        $this->feedbackType = 'info';

        try {
            $aplicativoId = $state['aplicativo_id'];
            $aplicativo = CatAplicativo::findOrFail($aplicativoId);

            $pruebasIds = \App\Models\Sesion::where('aplicativo_id', $aplicativoId)
                ->pluck('prueba_id')
                ->filter()
                ->unique();

            $pruebas = PruebaUsabilidad::whereIn('id', $pruebasIds)
                ->with(['tareas', 'hallazgos.severidad', 'hallazgos.prioridad'])
                ->get();

            if ($pruebas->isEmpty()) {
                $this->backlogContent = null;
                $this->backlogData = [];
                $this->feedbackMessage = 'No se encontraron pruebas de usabilidad vinculadas a este aplicativo.';
                $this->feedbackType = 'warning';

                Notification::make()
                    ->title('Sin datos suficientes')
                    ->body('No se encontraron pruebas de usabilidad vinculadas a este aplicativo.')
                    ->warning()
                    ->send();

                return;
            }

            $this->loadBacklogFromHistory($agent->generateGlobalDraft($pruebas, $aplicativo->nombre));

            $this->feedbackMessage = 'Backlog generado correctamente. Ya puedes revisarlo o exportarlo.';
            $this->feedbackType = 'success';

            Notification::make()
                ->title('Backlog Generado')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            $this->backlogContent = null;
            $this->backlogData = [];
            $this->feedbackMessage = 'No se pudo generar el backlog: ' . $e->getMessage();
            $this->feedbackType = 'danger';

            Notification::make()
                ->title('Error al generar el backlog')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function saveHistory(): void
    {
        $aplicativoId = $this->data['aplicativo_id'] ?? null;
        $content = $this->getCurrentBacklogContent();

        if (!$aplicativoId || trim($content) === '') {
            Notification::make()
                ->title('Error al guardar')
                ->body('Debe seleccionar un aplicativo y tener contenido generado.')
                ->danger()
                ->send();
            return;
        }

        $history = SprintBacklogHistory::create([
            'aplicativo_id' => $aplicativoId,
            'content' => $content,
            'version_name' => 'Backlog ' . now()->format('d/m/Y H:i'),
        ]);

        $this->data['version_id'] = $history->id;

        Notification::make()
            ->title('Historial Guardado')
            ->body('El backlog se ha guardado correctamente en el historial.')
            ->success()
            ->send();
    }

    public function previewPdf()
    {
        $content = $this->backlogData['backlogContent'] ?? $this->backlogContent ?? '';
        
        if (empty($content)) {
            Notification::make()->title('No hay contenido para previsualizar')->warning()->send();
            return;
        }

        // Convertimos Markdown a HTML para que el PDF se vea bien
        $htmlContent = Str::markdown($content);

        $pdf = Pdf::loadView('pdf.sprint-backlog', [
            'content' => $htmlContent,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'preview-backlog.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="preview-backlog.pdf"',
        ]);
    }

    public function exportMd()
    {
        $content = $this->getCurrentBacklogContent();
        $filename = 'Sprint-Backlog-' . Str::slug((string) ($this->data['aplicativo_id'] ?? 'backlog')) . '.md';

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename);
    }

    public function exportPdf()
    {
        $content = $this->getCurrentBacklogContent();
        $filename = 'Sprint-Backlog-' . Str::slug((string) ($this->data['aplicativo_id'] ?? 'backlog')) . '.pdf';

        return response()->streamDownload(function () use ($content) {
            echo "SPRINT BACKLOG GLOBAL\n\n";
            echo $content;
        }, $filename);
    }
}
