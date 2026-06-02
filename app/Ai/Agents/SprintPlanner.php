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
        return "Actúa como Scrum Master e IHC Senior experto en gestión ágil. " .
               "Tu tarea es transformar reportes de usabilidad en un Sprint Backlog estructurado. " .
               "DEBES RESPONDER EXCLUSIVAMENTE EN FORMATO JSON con la siguiente estructura:\n" .
               "{\n" .
               "  \"markdown\": \"(Texto completo del backlog en Markdown para el usuario)\",\n" .
               "  \"items\": [\n" .
               "    {\n" .
               "      \"type\": \"User Story\" o \"Technical Task\",\n" .
               "      \"title\": \"Título conciso\",\n" .
               "      \"description\": \"Descripción detallada\",\n" .
               "      \"priority\": \"Critical\", \"High\", \"Medium\" o \"Low\",\n" .
               "      \"story_points\": (Número entero basado en Fibonacci: 1, 2, 3, 5, 8, 13),\n" .
               "      \"epic\": \"Nombre de la Épica o categoría\",\n" .
               "      \"acceptance_criteria\": [\"Criterio 1\", \"Criterio 2\"]\n" .
               "    }\n" .
               "  ]\n" .
               "}\n" .
               "Reglas: Hallazgos Críticos/Altos -> User Stories. Hallazgos Medios -> Technical Tasks.";
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
    public function prompt(string $promptTexto): array
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return [
                'markdown' => "### ⚠️ Error de Configuración\nPor favor, añade tu clave de API `GEMINI_API_KEY=tu_clave` en tu archivo `.env` para habilitar este módulo.",
                'items' => []
            ];
        }

        // Restauramos EXACTAMENTE los modelos que tenías funcionando
        $modelos = [
            'gemini-2.5-flash', // Tu modelo principal original
            'gemini-1.5-flash', // Tu modelo de respaldo original
        ];
        $ultimoError = 'Error desconocido';

        foreach ($modelos as $modelo) {
            for ($intento = 1; $intento <= 2; $intento++) {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelo}:generateContent?key={$apiKey}";

                try {
                    // Intentamos con JSON mode, si falla, intentamos normal
                    $payload = [
                        'contents' => [
                            ['parts' => [['text' => $this->instructions() . "\n\nDatos de entrada:\n" . $promptTexto]]]
                        ]
                    ];

                    // Solo añadimos la configuración JSON si el modelo no es el "2.5" (por si acaso)
                    if ($modelo !== 'gemini-2.5-flash') {
                        $payload['generationConfig'] = ['response_mime_type' => 'application/json'];
                    }

                    $response = Http::withHeaders(['Content-Type' => 'application/json'])
                        ->timeout(35)
                        ->post($url, $payload);

                    if ($response->successful()) {
                        $rawText = $response->json('candidates.0.content.parts.0.text');
                        
                        // Intentamos limpiar si la IA puso triple comillas de markdown
                        $cleanJson = preg_replace('/^```json\s*|\s*```$/', '', trim($rawText));
                        $data = json_decode($cleanJson, true);
                        
                        if ($data && isset($data['markdown'])) {
                            return $data;
                        }

                        // Si no pudimos parsear pero tenemos texto, devolvemos al menos el texto
                        return [
                            'markdown' => $rawText,
                            'items' => []
                        ];
                    } else {
                        $ultimoError = "Google API ({$response->status()}): " . ($response->json('error.message') ?? $response->body());
                        if ($response->status() !== 503) break;
                        usleep(1500000);
                    }
                } catch (\Exception $e) {
                    $ultimoError = "Excepción: " . $e->getMessage();
                }
            }
        }

        return [
            'markdown' => "### ❌ Error en la Generación\n" . $ultimoError . "\n\n*Por favor, intenta de nuevo en unos segundos.*",
            'items' => []
        ];
    }

    /**
     * Mapea los datos del aplicativo de forma compacta.
     */
    public function generateGlobalDraft(Collection $pruebas, string $nombreAplicativo): array
    {
        $consolidado = $pruebas->map(function ($prueba) {
            $plan = "P: {$prueba->nombre}\n";
            $guia = $prueba->tareas ? $prueba->tareas->map(fn($t) => "- Tarea: {$t->nombre}")->implode("\n") : '';
            $sintesis = $prueba->hallazgos ? $prueba->hallazgos->map(fn($h) => "- H: {$h->problema} (Sev: " . ($h->severidad->nombre ?? 'N/A') . ")")->implode("\n") : '';
            
            return "{$plan}{$guia}\n{$sintesis}";
        })->implode("\n---\n");

        return $this->prompt(<<<PROMPT
            App: "{$nombreAplicativo}"
            Datos unificados de usabilidad:
            {$consolidado}
            
            Tarea: Genera el Sprint Backlog completo con Épicas, Story Points y criterios.
            PROMPT);
    }
}