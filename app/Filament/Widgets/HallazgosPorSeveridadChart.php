<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Hallazgo;

class HallazgosPorSeveridadChart extends ChartWidget
{
    // Título del gráfico (corregido sin la palabra 'static')
    protected ?string $heading = 'Hallazgos UX por Severidad'; 
    
    // El sort = 2 hace que este gráfico aparezca debajo de las tarjetas de estadísticas
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        // Traemos todos los hallazgos con su relación de severidad
        $hallazgos = Hallazgo::with('severidad')->get();
        
        // Agrupamos por el nombre de la severidad (Ej: Alta, Media, Baja)
        $agrupados = $hallazgos->groupBy(function($item) {
            return $item->severidad ? $item->severidad->nombre : 'Sin Severidad';
        });

        $labels = [];
        $data = [];

        foreach ($agrupados as $severidad => $items) {
            $labels[] = $severidad;
            $data[] = $items->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Hallazgos',
                    'data' => $data,
                    // Colores para las barras (Rojo, Naranja, Azul, Verde, Gris)
                    'backgroundColor' => ['#ef4444', '#f59e0b', '#3b82f6', '#10b981', '#6b7280'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // 'bar' para gráfico de barras. Puedes poner 'doughnut' o 'pie' si prefieres gráfico circular.
    }
}