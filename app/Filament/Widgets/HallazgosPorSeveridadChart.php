<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Hallazgo;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class HallazgosPorSeveridadChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    // Título del gráfico (corregido sin la palabra 'static')
    protected ?string $heading = 'Hallazgos UX por Severidad'; 
    
    // El sort = 2 hace que este gráfico aparezca debajo de las tarjetas de estadísticas
    protected static ?int $sort = 1; 

    protected function getData(): array
    {
        $pruebaId = $this->filters['prueba_id'] ?? null;

        // Traemos todos los hallazgos con su relación de severidad
        $query = Hallazgo::with('severidad');
        
        if ($pruebaId) {
            $query->where('prueba_id', $pruebaId);
        }

        $hallazgos = $query->get();
        
        // Agrupamos por el nombre de la severidad
        $agrupados = $hallazgos->groupBy(function($item) {
            return $item->severidad ? $item->severidad->nombre : 'Sin Severidad';
        });

        $labels = [];
        $data = [];
        $backgroundColors = [];

        $colorMap = [
            'Baja' => '#10b981',      // Verde
            'Media' => '#f59e0b',     // Naranja/Amarillo
            'Alta' => '#ef4444',      // Rojo
            'Crítica' => '#7f1d1d',   // Rojo oscuro
            'Sin Severidad' => '#6b7280'
        ];

        foreach ($agrupados as $severidad => $items) {
            $labels[] = $severidad;
            $data[] = $items->count();
            $backgroundColors[] = $colorMap[$severidad] ?? '#3b82f6';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Hallazgos',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
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