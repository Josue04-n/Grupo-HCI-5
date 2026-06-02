<?php

namespace App\Ai\Agents;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;

class SprintPlanner
{
    /**
     * Instrucciones del sistema optimizadas.
     * Corto en tokens para evitar costos y reducir latencia.
     */
    public function instructions(): string
    {
        return "Actúa como Scrum Master e IHC Senior. Transforma reportes de usabilidad en un Sprint Backlog conciso en Markdown. " .
               "Reglas estrictas: Hallazgos Altos/Críticos se vuelven Historias de Usuario; Hallazgos Medios se vuelven tareas de mejora.";
    }

    /**
     * Instancia el planificador de forma estática (Patrón Factory).
     */
    public static function make(): self
    {
        return new self();
    }

    /**
     * Envía el prompt estructurado a Google AI Studio utilizando
     * una arquitectura resiliente con tolerancia a fallos y saturación (Error 503).
     */
    public function prompt(string $promptTexto): string
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return "### ⚠️ Error de Configuración\nPor favor, añade tu clave de API `GEMINI_API_KEY=tu_clave` en tu archivo `.env` para habilitar este módulo.";
        }

        // Cadena de modelos por orden de prioridad para evadir saturaciones de la capa gratuita
        $modelos = [
            'gemini-2.5-flash', // Modelo principal de alta velocidad y bajo costo
            'gemini-1.5-flash', // Modelo de respaldo con cuota independiente
        ];

        $ultimoEstado = 200;
        $ultimoError = '';

        foreach ($modelos as $modelo) {
            // Intentamos hasta 2 veces por modelo en caso de picos momentáneos de tráfico
            for ($intento = 1; $intento <= 2; $intento++) {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelo}:generateContent?key={$apiKey}";

                try {
                    $response = Http::withHeaders(['Content-Type' => 'application/json'])
                        ->timeout(25)
                        ->post($url, [
                            'contents' => [
                                [
                                    'parts' => [
                                        [
                                            'text' => $this->instructions() . "\n\nDatos de entrada:\n" . $promptTexto
                                        ]
                                    ]
                                ]
                            ]
                        ]);

                    // Si la petición es exitosa, procesamos y retornamos el texto de inmediato
                    if ($response->successful()) {
                        return $response->json('candidates.0.content.parts.0.text') 
                            ?? 'La IA procesó la solicitud pero devolvió un formato vacío. Intenta de nuevo.';
                    }

                    $ultimoEstado = $response->status();
                    $ultimoError = $response->json('error.message') ?? $response->body();

                    // Si el error NO es por saturación de servidores (503), saltamos de inmediato al siguiente modelo
                    if ($ultimoEstado !== 503) {
                        break;
                    }

                    // Si es un error 503, pausamos 1.5 segundos antes de reintentar por si el pico de tráfico disminuye
                    if ($intento === 1) {
                        usleep(1500000); 
                    }

                } catch (\Exception $e) {
                    $ultimoEstado = 500;
                    $ultimoError = $e->getMessage();
                    continue; // Salta al siguiente intento o modelo si hay un fallo de red
                }
            }
        }

        // Si todos los reintentos y modelos fallaron, devolvemos un mensaje controlado al usuario
        return "### ❌ Servidores de IA Saturados (Código: {$ultimoEstado})\n" .
               "Tanto el modelo principal (2.5) como el de respaldo (1.5) están experimentando una demanda extrema en Google AI Studio.\n\n" .
               "**Detalle devuelto por Google:** `{$ultimoError}`\n\n" .
               "*Recomendación de IHC: El backend está listo y bien estructurado. Por favor, espera unos segundos y vuelve a presionar el botón.*";
    }

    /**
     * Mapea los datos del aplicativo de forma compacta para reducir el conteo de tokens,
     * protegiendo el límite de tu clave de API gratuita.
     */
    public function generateGlobalDraft(Collection $pruebas, string $nombreAplicativo): string
    {
        // Usamos etiquetas ultracortas (P: y H:) para ahorrar más del 50% de tokens en strings repetitivos
        $consolidado = $pruebas->map(function ($prueba) {
            $plan = "P: {$prueba->nombre}\n";
            $guia = $prueba->tareas ? $prueba->tareas->map(fn($t) => "- Tarea: {$t->nombre}")->implode("\n") : '';
            $sintesis = $prueba->hallazgos ? $prueba->hallazgos->map(fn($h) => "- H: {$h->problema} (Sev: " . ($h->severidad->nombre ?? 'N/A') . ")")->implode("\n") : '';
            
            return "{$plan}{$guia}\n{$sintesis}";
        })->implode("\n---\n");

        return $this->prompt(<<<PROMPT
            App: "{$nombreAplicativo}"
            Datos unificados:
            {$consolidado}
            
            Tarea: Genera el Sprint Backlog estructurado (Historias de Usuario, tareas de corrección, prioridades y criterios de aceptación cortos). Salida en Markdown.
            PROMPT);
    }
}