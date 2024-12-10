<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informe de Servicios Destacados</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            background-color: #ffffff;  /* Fondo blanco */
        }

        /* Variables para mantener consistencia */
        :root {
            --font-primary: Arial, Helvetica, sans-serif;  /* Aseguramos Arial como fuente principal */
            --color-text-primary: #2e2e30;
            --color-text-secondary: #757575;
        }

        /* Estilos base */
        body {
            font-family: var(--font-primary) !important;  /* Forzamos Arial */
            line-height: 1.4;
            color: var(--color-text-primary);
            margin: 0;
            padding: 30px;  /* Aumentar padding general */
            background-color: #ffffff;  /* Fondo blanco */
        }

        /* Asegurar que todos los elementos usen Arial */
        * {
            font-family: var(--font-primary) !important;
        }

        /* Ajustar específicamente los elementos que mostraban Times New Roman */
        .info-value, 
        .info-label,
        .status-badge,
        td,
        th {
            font-family: var(--font-primary) !important;
        }

        .status-badge {
            font-family: var(--font-primary) !important;
            font-size: 10px;
            font-weight: 500;
        }

        /* Contenedor principal para dar margen a todo el contenido */
        .content-wrapper {
            max-width: 95%;  /* Ancho máximo del contenido */
            margin: 0 auto;  /* Centrar contenido */
        }

        /* Encabezado */
        .header {
            text-align: center;
            margin-bottom: 4px;
            padding-top: 10px;
        }

        .company-name {
            font-family: var(--font-primary);
            font-size: 24px;
            font-weight: bold;
            color: var(--color-text-primary);
            margin-bottom: 2px;
            text-align: center;
        }

        .report-title {
            font-family: var(--font-primary);
            font-size: 20px;
            color: var(--color-text-primary);
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        /* Información */
        .info-container {
            margin-bottom: 5px;
            margin-top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
        }

        .info-group {
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: center;           /* Centrar texto */
        }

        .info-label {
            font-family: var(--font-primary);
            font-size: 11px;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-family: var(--font-primary);
            font-size: 13px;
            color: var(--color-text-primary);
            font-weight: 500;
        }

        /* Separador */
        .separator {
            margin: 25px 0;              /* Espacio arriba y abajo */
            height: 1px;                 /* Altura del separador */
            background: linear-gradient(
                to right,
                rgba(0,0,0,0.02),
                rgba(0,0,0,0.06) 20%,
                rgba(0,0,0,0.06) 80%,
                rgba(0,0,0,0.02)
            );
        }

        /* Contenedor de la tabla sin bordes redondeados */
        .table-container {
            margin: 10px 0;
            border: none;  /* Quitar borde del contenedor */
            border-radius: 0;  /* Quitar bordes redondeados */
            overflow: visible;  /* Permitir que los bordes se vean */
        }

        /* Ajustar tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
            border: 1px solid #e0e0e0;
        }

        /* Encabezados */
        th {
            padding: 8px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            background-color: #f5f5f5;
            border: 1px solid #e0e0e0;
            text-align: left;
        }

        /* Hacer la columna de estado más ancha */
        th:last-child {
            width: 100px;  /* Ancho fijo para la columna de estado */
        }

        /* Celdas de datos */
        td {
            padding: 12px 8px;  /* Aumentar el padding vertical para 2 líneas */
            font-size: 11px;
            line-height: 1.4;   /* Aumentar line-height */
            border: 1px solid #e0e0e0;
            vertical-align: middle;
            min-height: 40px;   /* Altura mínima para 2 líneas */
        }

        /* Ajustar el texto largo */
        td {
            white-space: normal;  /* Permitir wrap del texto */
            word-wrap: break-word;
            max-width: 200px;     /* Ancho máximo para celdas con texto largo */
        }

        /* Quitar estilos de filas alternadas */
        tbody tr:nth-child(even),
        tbody tr:nth-child(odd) {
            background-color: white;
        }

        /* Ajustar hover si lo deseas */
        tbody tr:hover {
            background-color: #f3f4f8;  /* Un tono más oscuro al hover */
        }

        /* Asegurar que las celdas hereden el color de fondo */
        td {
            padding: 4px 8px;  /* Reducir padding vertical */
            font-size: 12px;
            color: #424242;
            line-height: 1.2;  /* Reducir espacio entre líneas */
            background-color: inherit;  /* Heredar el color de fondo de la fila */
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        /* Quitar bordes redondeados de las celdas individuales */
        td:first-child, td:last-child {
            border-radius: 0;
        }

        /* Ajustar badges de estado */
        .status-badge {
            padding: 4px 8px;     /* Aumentar padding */
            font-size: 10px;      /* Aumentar tamaño de fuente */
            border-radius: 4px;
            display: inline-block;
            font-weight: 500;
            width: 80px;          /* Ancho fijo para los badges */
            text-align: center;   /* Centrar texto */
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Centrar la celda de estado */
        td:last-child {
            text-align: center;
        }

        /* Estilos específicos para cada estado */
        .status-pendiente {
            background-color: #fff3e0;
            color: #e65100;
        }

        .status-en_proceso {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .status-completado {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        /* Iconos más simples */
        .th-icon {
            width: 12px;
            height: 12px;
            margin-right: 4px;
            vertical-align: middle;
        }

        /* Pie de página */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 10px;
            padding-top: 5px;
        }

        .logo {
            width: 80px;
            height: auto;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <!-- Logo -->
        <div class="logo-container">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logos/logo.png'))) }}" 
                 class="logo" 
                 alt="Logo Global Acero">
        </div>

        <!-- Encabezado del documento -->
        <div class="header">
            <div class="company-name">GLOBAL ACERO 26, C.A.</div>
            <div class="report-title">Informe de Servicios Destacados</div>
        </div>

        <!-- Contenedor de información del reporte -->
        <div class="info-container">
            <div class="info-group">
                <span class="info-label">Técnico Responsable:</span>
                <span class="info-value">Edward Centeno</span>
            </div>
            <div class="info-group">
                <span class="info-label">Período:</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
                    -
                    {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <!-- Nuevo separador -->
        <div class="separator"></div>

        <!-- Tabla de actividades -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Sede</th>
                        <th>Departamento</th>
                        <th>Servicio</th>
                        <th>Diagnóstico</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Iteración sobre las actividades ordenadas por fecha -->
                    @foreach($actividades->sortBy('fecha') as $actividad)
                        <tr>
                            <td>{{ str_pad($actividad->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $actividad->sede_nombre }}</td>
                            <td>{{ $actividad->departamento }}</td>
                            <td>{{ $actividad->servicio }}</td>
                            <td>{{ $actividad->diagnostico }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($actividad->estado) }}">
                                    {{ ucfirst($actividad->estado) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html> 