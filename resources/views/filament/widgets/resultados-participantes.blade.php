<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Resultados por Participante
        </x-slot>

        @if(!$hayProyecto)
            <div style="text-align: center; color: #6b7280; padding: 1rem;">
                Por favor, selecciona un proyecto en el filtro superior para ver la tabla de resultados.
            </div>
        @elseif($participantes->isEmpty() || $tareas->isEmpty())
            <div style="text-align: center; color: #6b7280; padding: 1rem;">
                No hay suficientes datos registrados (participantes o tareas) para este proyecto.
            </div>
        @else
            <div style="overflow-x: auto; margin-top: 1rem;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--fi-color-gray-200); background-color: var(--fi-color-gray-50);">
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--fi-color-gray-700);">Participante</th>
                            @foreach($tareas as $tarea)
                                <th style="padding: 12px 16px; text-align: center; font-weight: 600; color: var(--fi-color-gray-700);" title="{{ $tarea->escenario }}">
                                    {{ $tarea->codigo }}
                                </th>
                            @endforeach
                            <th style="padding: 12px 16px; text-align: center; font-weight: 600; color: var(--fi-color-gray-700);">Éxito</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participantes as $participante)
                            <tr style="border-bottom: 1px solid var(--fi-color-gray-200); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--fi-color-gray-50)'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 12px 16px; font-weight: 500;">
                                    {{ $participante->codigo }} 
                                    <span style="font-size: 0.75rem; color: var(--fi-color-gray-500); display: block;">{{ $participante->perfil }}</span>
                                </td>
                                
                                @foreach($tareas as $tarea)
                                    @php
                                        $resultado = $resultados[$participante->id][$tarea->id] ?? null;
                                        $icono = '-';
                                        
                                        if ($resultado === 'Sí, sin ayuda' || $resultado === 'Sí, con poca ayuda' || $resultado === 'Sí, con mucha ayuda') {
                                            $icono = '✅';
                                        } elseif ($resultado === 'No completó') {
                                            $icono = '❌';
                                        }
                                    @endphp
                                    <td style="padding: 12px 16px; text-align: center; font-size: 1.125rem;" title="{{ $resultado ?? 'No evaluado' }}">
                                        {{ $icono }}
                                    </td>
                                @endforeach

                                <td style="padding: 12px 16px; text-align: center; font-weight: bold;">
                                    @php
                                        $porcentaje = $porcentajeExito[$participante->id] ?? 0;
                                        $color = $porcentaje >= 75 ? 'var(--fi-color-success-600)' : ($porcentaje >= 50 ? 'var(--fi-color-warning-600)' : 'var(--fi-color-danger-600)');
                                    @endphp
                                    <span style="color: {{ $color }};">{{ $porcentaje }}%</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <style>
                /* Soporte para modo oscuro mediante las variables de Filament */
                .dark table thead tr {
                    background-color: rgba(255, 255, 255, 0.05) !important;
                    border-bottom-color: rgba(255, 255, 255, 0.1) !important;
                }
                .dark table thead th {
                    color: #d1d5db !important;
                }
                .dark table tbody tr {
                    border-bottom-color: rgba(255, 255, 255, 0.05) !important;
                }
                .dark table tbody tr:hover {
                    background-color: rgba(255, 255, 255, 0.02) !important;
                }
                .dark table tbody td span {
                    color: #9ca3af !important;
                }
            </style>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
