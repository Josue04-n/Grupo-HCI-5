<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Observacion;
use Illuminate\Support\Facades\DB;

class EstadisticasPorAplicativo extends ChartWidget
{
    // QUITAMOS EL 'static' AQUÍ:
    protected ?string $heading = 'Rendimiento: JEP vs Maquita';

    protected function getData(): array
    {
        // Usamos Query Builder para evitar problemas de relaciones en dicho modelo 
        $data = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->join('cat_aplicativos', 'sesiones.aplicativo_id', '=', 'cat_aplicativos.id')
            ->select('cat_aplicativos.nombre', DB::raw('AVG(observaciones.tiempo_seg) as promedio_tiempo'))
            ->groupBy('cat_aplicativos.nombre')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Tiempo Promedio (Segundos)',
                    'data' => $data->pluck('promedio_tiempo')->map(fn($val) => round($val, 2)),
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
}