<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MondayService
{
    protected string $token;
    protected string $boardId;
    protected string $apiUrl = 'https://api.monday.com/v2';

    public function __construct()
    {
        $this->token = (string) env('MONDAY_API_TOKEN');
        $this->boardId = (string) env('MONDAY_BOARD_ID');
    }

    /**
     * Verifica si la configuración está completa.
     */
    public function isConfigured(): bool
    {
        return !empty($this->token) && !empty($this->boardId);
    }

    /**
     * Ejecuta una consulta GraphQL en Monday.
     */
    protected function query(string $query, array $variables = []): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Content-Type' => 'application/json',
            'API-Version' => '2023-10',
        ])->post($this->apiUrl, [
            'query' => $query,
            'variables' => $variables,
        ]);

        if ($response->failed()) {
            Log::error('Monday API Error: ' . $response->body());
            throw new \Exception('Error al conectar con Monday.com: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Crea un nuevo grupo en el tablero para el Sprint actual.
     */
    public function createGroup(string $groupName): string
    {
        $query = 'mutation ($boardId: ID!, $groupName: String!) {
            create_group (board_id: $boardId, group_name: $groupName) {
                id
            }
        }';

        $result = $this->query($query, [
            'boardId' => $this->boardId,
            'groupName' => $groupName,
        ]);

        return $result['data']['create_group']['id'];
    }

    /**
     * Crea un ítem (Historia o Tarea) dentro de un grupo con columnas específicas.
     */
    public function createItem(string $groupId, array $itemData): void
    {
        $query = 'mutation ($boardId: ID!, $groupId: String!, $itemName: String!, $columnValues: JSON!) {
            create_item (board_id: $boardId, group_id: $groupId, item_name: $itemName, column_values: $columnValues) {
                id
            }
        }';

        // Mapeo de prioridades a etiquetas exactas de tu Monday (según captura)
        $priorityLabel = match($itemData['priority'] ?? 'Medium') {
            'Critical' => 'Crítica',
            'High' => 'Alta',
            'Medium' => 'Media',
            'Low' => 'Baja',
            default => 'Media',
        };

        // Mapeo de columnas basado en tus capturas de pantalla:
        $columnValues = json_encode([
            'status' => ['label' => 'Listo para empezar'], // Estado inicial solicitado
            'priority' => ['label' => $priorityLabel], // Prioridad en español
            'numbers' => $itemData['story_points'] ?? 0, // SP Estimado
            'numbers5' => 0, // SP Reales
            'texto' => $itemData['epic'] ?? 'General', // Columna Épica
            'link' => [
                'url' => 'https://github.com/Josue04-n/Grupo-HCI-5', 
                'text' => 'Repositorio GitHub'
            ],
        ]);

        $this->query($query, [
            'boardId' => $this->boardId,
            'groupId' => $groupId,
            'itemName' => $itemData['title'],
            'columnValues' => $columnValues,
        ]);
    }

    /**
     * Sincroniza un backlog completo.
     */
    public function syncBacklog(string $sprintName, array $items): int
    {
        $groupId = $this->createGroup($sprintName);
        $count = 0;

        foreach ($items as $item) {
            $this->createItem($groupId, $item);
            $count++;
        }

        return $count;
    }
}
