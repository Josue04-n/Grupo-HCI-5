<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Observacion;
use Illuminate\Support\Facades\DB;

class StatsHCI extends BaseWidget
{
    protected function getStats(): array
    {
        // Datos JEP (Suponiendo ID 1)
        $erroresJep = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 1)->sum('errores');

        // Datos Maquita (Suponiendo ID 2)
        $erroresMaquita = DB::table('observaciones')
            ->join('sesiones', 'observaciones.sesion_id', '=', 'sesiones.id')
            ->where('sesiones.aplicativo_id', 2)->sum('errores');

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
