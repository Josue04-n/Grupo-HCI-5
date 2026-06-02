<?php

namespace App\Http\Controllers;

use App\Models\PruebaUsabilidad;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Attributes\Authorize;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class BacklogExportController extends Controller
{
    /**
     * Exporta el contenido del backlog a un archivo Markdown.
     * Usa el atributo #[Authorize] de Laravel 13 para verificar permisos sobre el modelo.
     */
    #[Authorize('view', 'prueba')]
    public function exportMarkdown(Request $request, PruebaUsabilidad $prueba): Response
    {
        $content = $request->input('content');
        $date = now()->format('Y-m-d');
        $filename = "Sprint-Backlog-" . Str::slug($prueba->producto) . "-{$date}.md";

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename, [
            'Content-Type' => 'text/markdown',
        ]);
    }

    /**
     * Exporta el contenido a PDF.
     * En una implementación real, aquí se usaría DomPDF, Browsershot o similar.
     */
    #[Authorize('view', 'prueba')]
    public function exportPdf(Request $request, PruebaUsabilidad $prueba): Response
    {
        $content = $request->input('content');
        $date = now()->format('Y-m-d');
        $filename = "Sprint-Backlog-" . Str::slug($prueba->producto) . "-{$date}.pdf";

        // Nota: Para fines del prototipo, retornamos un PDF simulado o el texto plano
        // si no hay una librería de PDF instalada aún.
        return response()->streamDownload(function () use ($content, $prueba) {
            echo "SPRINT BACKLOG - UX TEST: {$prueba->producto}\n";
            echo "Fecha: " . now()->toDateTimeString() . "\n";
            echo "------------------------------------------\n\n";
            echo $content;
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
