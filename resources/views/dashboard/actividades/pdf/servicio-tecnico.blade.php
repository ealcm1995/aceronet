<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Servicio Técnico #{{ $actividad->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .info-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: left;
            width: 30%;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 5px;
            margin: 15px 0;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 50px;
            text-align: center;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <div class="title">FORMATO DE SERVICIO TÉCNICO</div>
        <div>Nº: ST-{{ str_pad($actividad->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="section-title">1. INFORMACIÓN GENERAL</div>
    <table class="info-table">
        <tr>
            <th>Fecha</th>
            <td>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
            <th>Estado</th>
            <td>{{ ucfirst($actividad->estado) }}</td>
        </tr>
        <tr>
            <th>Sede</th>
            <td>
                @php
                    $sedeNombre = DB::table('sedes')
                        ->where('id', $actividad->sede)
                        ->value('nombre');
                @endphp
                {{ $sedeNombre ?? 'Sin asignar' }}
            </td>
            <th>Departamento</th>
            <td>{{ $actividad->departamento }}</td>
        </tr>
    </table>

    <div class="section-title">2. DETALLES DEL SERVICIO</div>
    <table class="info-table">
        <tr>
            <th>Tipo de Servicio</th>
            <td colspan="3">{{ $actividad->servicio }}</td>
        </tr>
        <tr>
            <th>Responsable</th>
            <td colspan="3">
                @php
                    $responsableNombre = DB::table('responsable')
                        ->where('id', $actividad->responsable_id)
                        ->value('nombre');
                @endphp
                {{ $responsableNombre ?? 'Sin asignar' }}
            </td>
        </tr>
        <tr>
            <th>Diagnóstico</th>
            <td colspan="3">{{ $actividad->diagnostico }}</td>
        </tr>
    </table>

    <div class="section-title">3. DESCRIPCIÓN DEL TRABAJO REALIZADO</div>
    <table class="info-table">
        <tr>
            <td style="min-height: 100px;">{{ $actividad->descripcion }}</td>
        </tr>
    </table>

    <div class="section-title">4. SOLUCIÓN IMPLEMENTADA</div>
    <table class="info-table">
        <tr>
            <td style="min-height: 100px;">{{ $actividad->solucion ?? 'Sin solución registrada' }}</td>
        </tr>
    </table>

    <div class="signatures">
        <div class="signature-line">
            Técnico Responsable<br>
            {{ $actividad->responsable_id }}
        </div>
        <div class="signature-line">
            Conformidad del Usuario<br>
            _____________________
        </div>
    </div>

    <div class="footer">
        Documento generado el {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html> 