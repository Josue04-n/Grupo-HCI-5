<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Observacion;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class EstadisticasPorAplicativo extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Rendimiento: JEP vs Maquita';
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        $pruebaId = $this->filters['prueba_id'] ?? null;

        // Usamos Query Builder para evitar problemas de relaciones en el modelo
        $query = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->join('cat_aplicativos', 'sesiones.aplicativo_id', '=', 'cat_aplicativos.id')
            ->select('cat_aplicativos.nombre', DB::raw('AVG(observaciones.tiempo_seg) as promedio_tiempo'))
            ->groupBy('cat_aplicativos.nombre');

        if ($pruebaId) {
            $query->where('sesiones.prueba_id', $pruebaId);
        }

        $data = $query->get();

        return [
            'datasets' => [
                [
                    'label' => 'Tiempo Promedio (Segundos)',
                    'data' => $data->pluck('promedio_tiempo')->map(fn($val) => round((float) $val, 2))->toArray(),
                    'backgroundColor' => [
                        '#3b82f6', // Azul para JEP
                        '#f59e0b', // Naranja para Maquita
                    ],
                ],
            ],
            'labels' => $data->pluck('nombre')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}