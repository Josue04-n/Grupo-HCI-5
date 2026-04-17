<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Tarea;
use App\Models\Participante;
use App\Models\Observacion;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ResultadosParticipantesWidget extends Widget
{
    use InteractsWithPageFilters;

    protected string $view = 'filament.widgets.resultados-participantes';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $pruebaId = $this->filters['prueba_id'] ?? null;

        if (!$pruebaId) {
            return [
                'tareas' => collect(),
                'participantes' => collect(),
                'resultados' => [],
                'hayProyecto' => false
            ];
        }

        $tareas = Tarea::where('prueba_id', $pruebaId)->orderBy('id')->get();
        $participantes = Participante::where('prueba_id', $pruebaId)->orderBy('id')->get();

        $observaciones = Observacion::whereHas('sesion', function ($query) use ($pruebaId) {
            $query->where('prueba_id', $pruebaId);
        })->with('sesion')->get();

        $resultados = [];
        $exitosPorParticipante = [];

        foreach ($observaciones as $obs) {
            $pId = $obs->sesion->participante_id;
            $tId = $obs->sesion->tarea_id;
            
            $resultados[$pId][$tId] = $obs->exito;

            if (!isset($exitosPorParticipante[$pId])) {
                $exitosPorParticipante[$pId] = ['completadas' => 0, 'total' => 0];
            }
            
            $exitosPorParticipante[$pId]['total']++;
            if ($obs->exito !== 'No completó') {
                $exitosPorParticipante[$pId]['completadas']++;
            }
        }

        $porcentajeExito = [];
        foreach ($exitosPorParticipante as $pId => $datos) {
            if ($datos['total'] > 0) {
                $porcentajeExito[$pId] = round(($datos['completadas'] / $datos['total']) * 100);
            } else {
                $porcentajeExito[$pId] = 0;
            }
        }

        return [
            'tareas' => $tareas,
            'participantes' => $participantes,
            'resultados' => $resultados,
            'porcentajeExito' => $porcentajeExito,
            'hayProyecto' => true
        ];
    }
}
