<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TasaExitoChart extends ChartWidget
{
    protected ?string $heading = 'Eficacia: % de Éxito Final (Porcentaje)';

    protected function getData(): array
    {
        $apps = ['Cooperativa JEP', 'Cooperativa Maquita'];
        $exitos = [];

        foreach ([1, 2] as $id) {
            $total = DB::table('observaciones')
                ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
                ->where('sesiones.aplicativo_id', $id)->count();
            
            $completas = DB::table('observaciones')
                ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
                ->where('sesiones.aplicativo_id', $id)
                ->where('exito', 'Sí, sin ayuda')->count();

           // $exitos[] = $total > 0 ? round(($completas / $total) * 100, 2) : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasa de Éxito (%)',
                    'data' => $exitos,
                    'backgroundColor' => ['#3b82f6', '#f59e0b'],
                ],
            ],
            'labels' => $apps,
        ];
    }

    protected function getType(): string
    {
        return 'polarArea'; // Un estilo circular muy elegante
    }
}