<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\Tarea;

class ComparativaTareasChart extends ChartWidget
{
    
    protected ?string $heading = 'Eficiencia: Errores por Tarea (JEP vs Maquita)';
    protected static ?int $sort = 1;
    

    protected function getData(): array
    {
        $tareas = Tarea::orderBy('id')->get();
        $labels = $tareas->pluck('codigo')->toArray(); 
        $tareaIds = $tareas->pluck('id')->toArray();

        $rawJep = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 1)
            ->groupBy('sesiones.tarea_id')
            ->select('sesiones.tarea_id', DB::raw('SUM(observaciones.errores) as total_errores'))
            ->pluck('total_errores', 'tarea_id')
            ->toArray();

        // 3. Consultamos los errores de Maquita (Aplicativo ID: 2)
        $rawMaquita = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 2)
            ->groupBy('sesiones.tarea_id')
            ->select('sesiones.tarea_id', DB::raw('SUM(observaciones.errores) as total_errores'))
            ->pluck('total_errores', 'tarea_id')
            ->toArray();

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