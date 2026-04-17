<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class TasaExitoChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Eficacia: % de Éxito Final (Porcentaje)';
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        $pruebaId = $this->filters['prueba_id'] ?? null;

        $apps = ['Cooperativa JEP', 'Cooperativa Maquita'];
        $exitos = [];

        foreach ([1, 2] as $id) {
            $queryTotal = DB::table('observaciones')
                ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
                ->where('sesiones.aplicativo_id', $id);

            if ($pruebaId) {
                $queryTotal->where('sesiones.prueba_id', $pruebaId);
            }

            $total = $queryTotal->count();
            
            $queryCompletas = DB::table('observaciones')
                ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
                ->where('sesiones.aplicativo_id', $id)
                ->where('exito', 'Sí, sin ayuda');

            if ($pruebaId) {
                $queryCompletas->where('sesiones.prueba_id', $pruebaId);
            }

            $completas = $queryCompletas->count();

            $exitos[] = $total > 0 ? round(($completas / $total) * 100, 2) : 0;
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