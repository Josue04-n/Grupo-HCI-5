<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Observacion;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsHCI extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $pruebaId = $this->filters['prueba_id'] ?? null;

        // Datos JEP (Suponiendo ID 1)
        $queryJep = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 1);

        if ($pruebaId) {
            $queryJep->where('sesiones.prueba_id', $pruebaId);
        }
        $erroresJep = $queryJep->sum('errores');

        // Datos Maquita (Suponiendo ID 2)
        $queryMaquita = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 2);

        if ($pruebaId) {
            $queryMaquita->where('sesiones.prueba_id', $pruebaId);
        }
        $erroresMaquita = $queryMaquita->sum('errores');

        return [
            Stat::make('Errores en JEP', $erroresJep)
                ->description('Total clics fallidos')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
            Stat::make('Errores en Maquita', $erroresMaquita)
                ->description('Total clics fallidos')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Brecha de Eficiencia', abs($erroresJep - $erroresMaquita) . ' errores')
                ->description('Diferencia entre apps')
                ->color('warning'),
        ];
    }
}