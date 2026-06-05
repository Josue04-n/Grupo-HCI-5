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
    public ?string $synthesis = null;
    public ?array $backlogData = [];
    public ?array $jsonItems = [];
    public bool $showPreview = false;
    public ?string $feedbackMessage = null;
    public ?string $feedbackType = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function togglePreview(): void
    {
        if (empty($this->getCurrentBacklogContent())) {
            Notification::make()->title('No hay contenido para previsualizar')->warning()->send();
            return;
        }
        $this->showPreview = !$this->showPreview;
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
                            $this->loadBacklogFromHistory($history->content, $history->json_data, $history->synthesis);

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
        $this->synthesis = null;
        $this->backlogData = [];
        $this->jsonItems = [];
        $this->feedbackMessage = null;
        $this->feedbackType = null;
    }

    protected function loadBacklogFromHistory(string $content, ?array $jsonData = null, ?string $synthesis = null): void
    {
        $this->jsonItems = $jsonData ?? [];
        $this->synthesis = $synthesis;
        
        // Si hay datos JSON pero el contenido no tiene el dashboard, lo inyectamos
        if (!empty($this->jsonItems) && !str_contains($content, 'DASHBOARD ESTRATÉGICO')) {
            $dashboard = $this->generateStrategicDashboard($this->jsonItems);
            $content = $dashboard . "\n\n---\n\n" . $content;
        }

        // Inyectamos la síntesis si existe y no está en el contenido
        if ($this->synthesis && !str_contains($content, 'SÍNTESIS Y RETROALIMENTACIÓN ESTRATÉGICA')) {
            $content .= "\n\n---\n\n## 💡 SÍNTESIS Y RETROALIMENTACIÓN ESTRATÉGICA\n\n" . $this->synthesis;
        }

        $this->backlogContent = $content;
        $this->backlogData = [
            'backlogContent' => $content,
        ];
    }

    protected function generateStrategicDashboard(array $items): string
    {
        $totalSP = collect($items)->sum('story_points');
        $userStories = collect($items)->where('type', 'User Story')->count();
        $techTasks = collect($items)->where('type', 'Technical Task')->count();
        $priorities = collect($items)->pluck('priority')->unique();
        
        $mainPriority = $priorities->contains('Critical') ? '🔴 Crítica' : ($priorities->contains('High') ? '🟠 Alta' : '🟡 Media');
        
        $valueScore = $this->calculateSprintValue($items);
        
        $markdown = "## 📊 DASHBOARD ESTRATÉGICO (Calculado)\n\n";
        $markdown .= "| Métrica | Detalle |\n";
        $markdown .= "| :--- | :--- |\n";
        $markdown .= "| **Resumen del Sprint** | {$userStories} Historias / {$techTasks} Tareas |\n";
        $markdown .= "| **Puntos de Historia (SP)** | Total: **{$totalSP} SP** |\n";
        $markdown .= "| **Prioridad General** | {$mainPriority} |\n";
        $markdown .= "| **Valor del Sprint** | **{$valueScore}/10** |\n";
        $markdown .= "| **Confianza IA** | 🟢 Alta (Basada en estructura JSON) |\n\n";
        
        $markdown .= "### 🎯 Objetivo del Sprint\n";
        $markdown .= "Resolver las " . count($items) . " necesidades detectadas priorizando la estabilidad y el impacto en el usuario.\n";
        
        return $markdown;
    }

    protected function calculateSprintValue(array $items): float
    {
        if (empty($items)) return 0;
        
        $score = 0;
        foreach ($items as $item) {
            $multiplier = match($item['priority'] ?? 'Medium') {
                'Critical' => 10,
                'High' => 8,
                'Medium' => 5,
                'Low' => 3,
                default => 5,
            };
            $score += $multiplier;
        }
        
        return round(($score / (count($items) * 10)) * 10, 1);
    }

    protected function getCurrentBacklogContent(): string
    {
        return (string) ($this->backlogData['backlogContent'] ?? $this->backlogContent ?? '');
    }

    public function generate(SprintPlanner $agent): void
    {
        set_time_limit(120);
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
            
            $content = $response['markdown'] ?? '';
            $this->synthesis = $response['synthesis'] ?? null;

            if ($this->synthesis) {
                $content .= "\n\n---\n\n## 💡 SÍNTESIS Y RETROALIMENTACIÓN ESTRATÉGICA\n\n" . $this->synthesis;
            }

            $this->loadBacklogFromHistory($content, $response['items'] ?? [], $this->synthesis);

            $this->feedbackMessage = 'Backlog generado correctamente con síntesis estratégica.';
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
            'synthesis' => $this->synthesis,
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
        $content = $this->getCurrentBacklogContent();
        
        if (empty($content)) {
            Notification::make()->title('No hay contenido para previsualizar')->warning()->send();
            return;
        }

        $aplicativo = CatAplicativo::find($this->data['aplicativo_id'])?->nombre;
        
        // Aseguramos que el contenido sea UTF-8 limpio antes de procesar
        $htmlContent = Str::markdown(mb_convert_encoding($content, 'UTF-8', 'UTF-8'));

        $pdf = Pdf::loadView('pdf.sprint-backlog', [
            'content' => $htmlContent,
            'aplicativo' => $aplicativo
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'preview.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="preview.pdf"',
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
        
        if (empty($content)) {
            Notification::make()->title('No hay contenido para exportar')->warning()->send();
            return;
        }

        $aplicativo = CatAplicativo::find($this->data['aplicativo_id']);
        $aplicativoNombre = $aplicativo?->nombre ?? 'Backlog';
        $filename = 'Sprint-Backlog-' . Str::slug($aplicativoNombre) . '.pdf';

        $htmlContent = Str::markdown($content);

        $pdf = Pdf::loadView('pdf.sprint-backlog', [
            'content' => $htmlContent,
            'aplicativo' => $aplicativoNombre
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
