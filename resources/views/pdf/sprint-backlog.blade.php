<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sprint Backlog - Professional Report</title>
    <style>
        @page { margin: 1.5cm; }
        body {
            font-family: 'Helvetica', sans-serif;
            color: #2d3748;
            line-height: 1.5;
            font-size: 11pt;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #6161FF;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 20pt;
            font-weight: bold;
            color: #1a202c;
            margin: 0;
        }
        .metadata {
            text-align: right;
            font-size: 9pt;
            color: #718096;
        }
        .user-info {
            margin-bottom: 20px;
            background: #f7fafc;
            padding: 10px;
            border-left: 4px solid #6161FF;
            font-size: 10pt;
        }
        .content {
            margin-top: 20px;
        }
        /* Markdown Styling */
        h2 { color: #2d3748; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 25px; font-size: 16pt; }
        h3 { color: #4a5568; margin-top: 20px; font-size: 13pt; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #edf2f7; text-align: left; padding: 8px; border: 1px solid #e2e8f0; }
        td { padding: 8px; border: 1px solid #e2e8f0; vertical-align: top; }
        ul { margin-bottom: 10px; }
        li { margin-bottom: 4px; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #a0aec0;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td>
                <h1 class="title">Sprint Backlog</h1>
                <p style="margin: 0; color: #4a5568;">{{ $aplicativo ?? 'Proyecto UX' }}</p>
            </td>
            <td class="metadata">
                Generado: {{ now()->format('d/m/Y H:i') }}<br>
                ID Reporte: {{ uniqid() }}
            </td>
        </tr>
    </table>

    <div class="user-info">
        <strong>Generado por:</strong> {{ auth()->user()->name ?? 'Asistente IA' }}<br>
        <strong>Email:</strong> {{ auth()->user()->email ?? 'n/a' }}<br>
        <strong>Rol:</strong> Scrum Master / IHC Analyst
    </div>

    <div class="content">
        {!! $content !!}
    </div>

    <div class="footer">
        © {{ date('Y') }} Dashboard de Usabilidad - Reporte generado automáticamente por IA & Local Logic.
    </div>
</body>
</html>
