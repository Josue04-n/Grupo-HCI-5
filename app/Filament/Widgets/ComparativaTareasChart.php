<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\Tarea;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ComparativaTareasChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Eficiencia: Errores por Tarea (JEP vs Maquita)';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $pruebaId = $this->filters['prueba_id'] ?? null;

        $tareasQuery = Tarea::orderBy('id');
        if ($pruebaId) {
            $tareasQuery->where('prueba_id', $pruebaId);
        }
        $tareas = $tareasQuery->get();
        $labels = $tareas->pluck('codigo')->toArray(); 
        $tareaIds = $tareas->pluck('id')->toArray();

        $queryJep = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 1)
            ->groupBy('sesiones.tarea_id')
            ->select('sesiones.tarea_id', DB::raw('SUM(observaciones.errores) as total_errores'));
            
        if ($pruebaId) {
            $queryJep->where('sesiones.prueba_id', $pruebaId);
        }
        
        $rawJep = $queryJep->pluck('total_errores', 'tarea_id')->toArray();

        // Consultamos los errores de Maquita (Aplicativo ID: 2)
        $queryMaquita = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 2)
            ->groupBy('sesiones.tarea_id')
            ->select('sesiones.tarea_id', DB::raw('SUM(observaciones.errores) as total_errores'));

        if ($pruebaId) {
            $queryMaquita->where('sesiones.prueba_id', $pruebaId);
        }

        $rawMaquita = $queryMaquita->pluck('total_errores', 'tarea_id')->toArray();

        $dataJep = [];
        $dataMaquita = [];

        foreach ($tareaIds as $id) {
            $dataJep[] = $rawJep[$id] ?? 0;
            $dataMaquita[] = $rawMaquita[$id] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cooperativa JEP',
                    'data' => $dataJep,
                    'backgroundColor' => '#3b82f6', // Azul
                    'borderColor' => '#2563eb',
                ],
                [
                    'label' => 'Cooperativa Maquita',
                    'data' => $dataMaquita,
                    'backgroundColor' => '#f59e0b', // Naranja
                    'borderColor' => '#d97706',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Cantidad de Errores',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Tareas del Plan',
                    ],
                ],
            ],
        ];
    }
}