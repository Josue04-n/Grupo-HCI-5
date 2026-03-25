<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\PruebaUsabilidad;
use App\Models\Observacion;
use App\Models\Hallazgo;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2; 

    protected function getStats(): array
    {
        $tareasExitosas = Observacion::where('exito', '!=', 'No completó')->count();
        $tiempoPromedio = Observacion::avg('tiempo_seg') ?? 0;
        $totalErrores = Observacion::sum('errores');
        $totalHallazgos = Hallazgo::count();

        return [
            Stat::make('Pruebas Creadas', PruebaUsabilidad::count())
                ->description('Planes de prueba activos')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),

            Stat::make('Tareas Exitosas', $tareasExitosas)
                ->description('Participantes que lograron la tarea')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Tiempo Promedio', number_format($tiempoPromedio, 2) . ' seg')
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