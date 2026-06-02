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
use App\Services\MondayService;
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
    public ?array $jsonItems = [];
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
                            $this->loadBacklogFromHistory($history->content, $history->json_data);

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
        $this->jsonItems = [];
        $this->feedbackMessage = null;
        $this->feedbackType = null;
    }

    protected function loadBacklogFromHistory(string $content, ?array $jsonData = null): void
    {
        $this->backlogContent = $content;
        $this->backlogData = [
            'backlogContent' => $content,
        ];
        $this->jsonItems = $jsonData ?? [];
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

            $response = $agent->generateGlobalDraft($pruebas, $aplicativo->nombre);
            
            $this->loadBacklogFromHistory($response['markdown'] ?? '', $response['items'] ?? []);

            $this->feedbackMessage = 'Backlog generado correctamente con Épicas y Story Points. Ya puedes publicarlo en Monday.com.';
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
            'json_data' => $this->jsonItems,
            'version_name' => 'Backlog ' . now()->format('d/m/Y H:i'),
        ]);

        $this->data['version_id'] = $history->id;

        Notification::make()
            ->title('Historial Guardado')
            ->body('El backlog y los datos para Monday se han guardado correctamente.')
            ->success()
            ->send();
    }

    public function publishToMonday(MondayService $monday): void
    {
        if (!$monday->isConfigured()) {
            Notification::make()
                ->title('Monday.com no configurado')
                ->body('Por favor, añade MONDAY_API_TOKEN y MONDAY_BOARD_ID a tu archivo .env')
                ->warning()
                ->send();
            return;
        }

        if (empty($this->jsonItems)) {
            Notification::make()
                ->title('Sin datos para Monday')
                ->body('Genera o carga un backlog con datos estructurados primero.')
                ->danger()
                ->send();
            return;
        }

        try {
            $aplicativo = CatAplicativo::find($this->data['aplicativo_id']);
            $sprintName = "Sprint " . now()->format('d/m/Y') . " - " . ($aplicativo->nombre ?? 'UX');

            $count = $monday->syncBacklog($sprintName, $this->jsonItems);

            Notification::make()
                ->title('Sincronización Exitosa')
                ->body("Se han creado {$count} ítems en el tablero de Monday.com.")
                ->success()
                ->duration(10000)
                ->send();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('Error al publicar en Monday')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
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
