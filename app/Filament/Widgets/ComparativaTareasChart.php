<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ComparativaTareasChart extends ChartWidget
{
    protected ?string $heading = 'Eficiencia: Errores por Tarea (JEP vs Maquita)';

    protected function getData(): array
    {
        $dataJep = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 1)
            ->groupBy('sesiones.tarea_id')
            ->orderBy('sesiones.tarea_id')
            ->pluck(DB::raw('SUM(errores)'), 'sesiones.tarea_id')->toArray();

        $dataMaquita = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 2)
            ->groupBy('sesiones.tarea_id')
            ->orderBy('sesiones.tarea_id')
            ->pluck(DB::raw('SUM(errores)'), 'sesiones.tarea_id')->toArray();

        return [
            
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}