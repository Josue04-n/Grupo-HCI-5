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
use App\Ai\Agents\SprintPlanner;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
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
                    ->live(),
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

            $this->backlogContent = $agent->generateGlobalDraft($pruebas, $aplicativo->nombre);
            $this->backlogData = [
                'backlogContent' => $this->backlogContent,
            ];

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

    public function exportMd()
    {
        $content = $this->backlogData['backlogContent'] ?? $this->backlogContent ?? '';
        $filename = 'Sprint-Backlog-' . Str::slug((string) ($this->data['aplicativo_id'] ?? 'backlog')) . '.md';

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename);
    }

    public function exportPdf()
    {
        $content = $this->backlogData['backlogContent'] ?? $this->backlogContent ?? '';
        $filename = 'Sprint-Backlog-' . Str::slug((string) ($this->data['aplicativo_id'] ?? 'backlog')) . '.pdf';

        return response()->streamDownload(function () use ($content) {
            echo "SPRINT BACKLOG GLOBAL\n\n";
            echo $content;
        }, $filename);
    }
}
