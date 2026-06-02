<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sprint Backlog</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4a5568;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2d3748;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #718096;
            font-size: 14px;
        }
        .content {
            font-size: 14px;
        }
        h1, h2, h3 {
            color: #2d3748;
        }
        pre {
            background: #f7fafc;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            white-space: pre-wrap;
        }
        /* Estilos básicos para simular Markdown */
        .markdown-body h1 { border-bottom: 1px solid #eee; padding-bottom: 0.3em; }
        .markdown-body h2 { border-bottom: 1px solid #eee; padding-bottom: 0.3em; margin-top: 24px; }
        .markdown-body ul { padding-left: 20px; }
        .markdown-body li { margin-bottom: 5px; }
        .markdown-body code { background: #f0f0f0; padding: 2px 4px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sprint Backlog Global</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="content markdown-body">
        {!! $content !!}
    </div>
</body>
</html>
