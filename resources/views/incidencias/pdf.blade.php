<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Incidencias</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; }
        .header-table { width: 100%; border: none; margin-bottom: 20px; }
        .logo { width: 120px; }
        .title-container { text-align:left; }
        h1 { margin: 0; color: #1e3a8a; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #dee2e6; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; color: #495057; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="border: none;">
                {{-- Usamos public_path para que dompdf encuentre la imagen en el servidor --}}
                <img src="{{ $logoBase64 }}" class="logo">
            </td>
            <td style="border: none;" class="title-container">
                <h1>Bitácora de Incidencias</h1>
                <p>Generado el: {{ date('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo de incidencia</th>
                <th>Sistema</th>
                <th>Área</th>
                <th>Descripción</th>
                <th>Observaciones</th>
                <th style="width: 80px;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incidencias as $incidencia)
            <tr>
                <td>{{ $incidencia->id }}</td>
                tipoIncidencia
                <td>{{ $incidencia->tipoIncidencia->nombre_tipo }}</td>
                <td>{{ $incidencia->sistema->nombre_sistema }}</td>
                <td>{{ $incidencia->area->nombre_area }}</td>
                <td>{{ $incidencia->descripcion }}</td>
                <td>{{ $incidencia->observaciones}}</td>
                <td>{{ $incidencia->created_at->format('d/m/Y') }}</td>
            </tr>                
            @endforeach
        </tbody>
    </table>

      
</body>
</html>
