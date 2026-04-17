<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\PruebaUsabilidad;
use App\Models\Observacion;
use App\Models\Hallazgo;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class DashboardStatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2; 

    protected function getStats(): array
    {
        $pruebaId = $this->filters['prueba_id'] ?? null;

        $observacionQuery = Observacion::query();
        $hallazgoQuery = Hallazgo::query();

        if ($pruebaId) {
            $observacionQuery->whereHas('sesion', function ($query) use ($pruebaId) {
                $query->where('prueba_id', $pruebaId);
            });
            $hallazgoQuery->where('prueba_id', $pruebaId);
        }

        $tareasExitosas = (clone $observacionQuery)->where('exito', '!=', 'No completó')->count();
        $tiempoPromedio = (clone $observacionQuery)->avg('tiempo_seg') ?? 0;
        $totalErrores = (clone $observacionQuery)->sum('errores');
        $totalHallazgos = $hallazgoQuery->count();

        // Mostrar 'Pruebas Creadas' siempre o, si está filtrado, podemos mostrar 'Participantes' u otra métrica relevante?
        // Dejaremos Pruebas Creadas, o podemos mostrar el total del sistema.
        $pruebasCreadas = PruebaUsabilidad::count();

        return [
            Stat::make('Pruebas Creadas', $pruebasCreadas)
                ->description('Planes de prueba activos en total')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),

            Stat::make('Tareas Exitosas', $tareasExitosas)
                ->description('Participantes que lograron la tarea')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Tiempo Promedio', number_format((float) $tiempoPromedio, 2) . ' seg')
                ->description('Duración media por tarea')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total de Errores', $totalErrores)
                ->description('Clics erróneos y retrocesos sumados')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
                
            Stat::make('Hallazgos Detectados', $totalHallazgos)
                ->description('Oportunidades de mejora UX')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('primary'),
        ];
    }
}