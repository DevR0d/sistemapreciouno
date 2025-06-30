<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Validación de Guía</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
            --border-color: #dee2e6;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
            color: #333;
            background-color: #fff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table td,
        .table th {
            border: 1px solid var(--border-color);
            padding: 6px 8px;
            text-align: left;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .title {
            text-align: center;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 12px;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--secondary-color);
        }

        .section-title {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 10px;
            font-weight: 600;
            font-size: 12px;
            margin: 20px 0 10px 0;
            border-radius: 2px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: 600;
        }

        .header,
        .footer {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }

        .header {
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            padding: 0;
        }

        .footer {
            font-size: 9px;
            margin-top: 20px;
            color: #666;
            padding-top: 10px;
            border-top: 1px solid var(--border-color);
        }

        .header td {
            padding: 5px 8px;
            vertical-align: middle;
            border: 1px solid var(--border-color);
            border-collapse: collapse;
        }

        .logo {
            max-width: 80px;
            height: auto;
        }

        .footer p {
            margin: 3px 0;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: var(--light-gray);
        }

        /* Estilos específicos para los grupos de productos */
        h4 {
            font-size: 12px;
            margin: 15px 0 8px 0;
            padding: 5px 8px;
            border-left: 3px solid;
            background-color: rgba(0,0,0,0.03);
        }

        h4[style*="BUENO"] {
            border-left-color: var(--success-color);
            color: var(--success-color);
        }

        h4[style*="REGULAR"] {
            border-left-color: var(--warning-color);
            color: var(--warning-color);
        }

        h4[style*="DAÑADO"] {
            border-left-color: var(--danger-color);
            color: var(--danger-color);
        }

        h4[style*="PENDIENTE"] {
            border-left-color: var(--dark-gray);
            color: var(--dark-gray);
        }

        /* Responsive */
        @media print {
            body {
                padding: 10px;
                font-size: 10px;
            }
            .table td, .table th {
                padding: 4px 6px;
            }
        }
    </style>
</head>

<body>

<!-- Header with logo -->
<table class="header">
    <tr>
        <td rowspan="3" style="width: 25%; text-align: center;">
            <strong>TOTTUS</strong><br>
            <small>{{ $guia->razonsocialguia ?? 'N/A' }}</small><br>
            R.U.C. Nº {{ $tipoempresa->ruc ?? 'N/A' }}
        </td>
        <td class="title" colspan="2">REPORTE DE VALIDACION</td>
        <td style="width: 25%; text-align: center;">
            <strong>N° {{ $guia->codigoguia ?? 'N/A' }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="3"><strong>Razón Social:</strong> {{ $guia->razonsocialguia ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Fecha Emisión:</strong> {{ $guia->fechaemision ?? 'N/A' }}</td>
        <td><strong>Hora Emisión:</strong> {{ $guia->horaemision ?? 'N/A' }}</td>
        <td><strong>Motivo:</strong> {{ $guia->motivotraslado ?? 'Venta' }}</td>
    </tr>
</table>

<!-- Transport Data -->
<div class="section-title text-center">UNIDAD DE TRANSPORTE DEL CONDUCTOR</div>
<table class="table">
    <tr>
        <td style="width: 40%;">
            <strong style="color: var(--primary-color);">Transportista:</strong>
            <span style="font-weight: 500;">{{ $transporte->nombre_razonsocial ?? 'N/A' }}</span>
        </td>
        <td style="width: 30%;">
            <strong style="color: var(--primary-color);">RUC:</strong>
            <span style="font-weight: 500;">{{ $transporte->ruc_transportista ?? 'N/A' }}</span>
        </td>
        <td style="width: 30%;">
            <strong style="color: var(--primary-color);">Modalidad:</strong>
            <span style="font-weight: 500;">{{ $transporte->modalidadtraslado ?? 'N/A' }}</span>
        </td>
    </tr>
    <tr>
        <td>
            <strong style="color: var(--primary-color);">Conductor:</strong>
            <span style="font-weight: 500;">{{ $conductor->nombre ?? 'N/A' }}</span>
        </td>
        <td>
            <strong style="color: var(--primary-color);">DNI:</strong>
            <span style="font-weight: 500;">{{ $conductor->dni ?? 'N/A' }}</span>
        </td>
        <td>
            <strong style="color: var(--primary-color);">Placa:</strong>
            <span style="font-weight: 500;">{{ $vehiculo->placa ?? 'N/A' }}</span>
        </td>
    </tr>
</table>

<!-- Validated Products -->
<div class="section-title">PRODUCTOS VALIDADOS</div>

@php
    $grupos = [
        'BUENO' => $productosBuenos,
        'REGULAR' => $productosRegulares,
        'DAÑADO' => $productosDanados,
        'PENDIENTE' => $productosSinCondicion
    ];
@endphp

@foreach($grupos as $tipo => $items)
    @if(count($items) > 0)
        <h4 style="color: {{ $tipo == 'BUENO' ? 'var(--success-color)' : ($tipo == 'REGULAR' ? 'var(--warning-color)' : ($tipo == 'DAÑADO' ? 'var(--danger-color)' : 'var(--dark-gray)')) }};">
            {{ ucfirst(strtolower($tipo)) }} ({{ count($items) }})
        </h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20%;">Código</th>
                <th style="width: 50%;">Descripción</th>
                <th style="width: 15%;">Cantidad</th>
                <th style="width: 15%;">Condición</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                @php $item = (object)$item; @endphp
                <tr>
                    <td style="font-family: 'Courier New', monospace; font-weight: 500;">{{ $item->codproducto ?? 'N/A' }}</td>
                    <td>{{ $item->producto ?? 'Sin descripción' }}</td>
                    <td class="text-center" style="font-weight: 500;">{{ number_format($item->cantidad ?? 0, 2) }}</td>
                    <td class="text-center" style="font-weight: 500;
                                color: {{ $item->nombretipocondicion == 'BUENO' ? 'var(--success-color)' :
                                        ($item->nombretipocondicion == 'REGULAR' ? 'var(--warning-color)' :
                                        ($item->nombretipocondicion == 'DAÑADO' ? 'var(--danger-color)' : 'var(--dark-gray)')) }};">
                        {{ $item->nombretipocondicion ?? 'PENDIENTE' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endforeach

<!-- Summary -->
<div class="section-title">RESUMEN</div>
<table class="table">
    <tr>
        <td style="width: 30%;">
            <strong style="color: var(--primary-color);">Total Validados:</strong>
            <span style="font-weight: 600;">{{ number_format($totalValidados, 2) }}</span>
        </td>
        <td style="width: 70%;">
            <strong style="color: var(--primary-color);">Observaciones Generales:</strong>
            <span style="font-weight: 500;">{{ $validacion->observaciones ?? 'Ninguna' }}</span>
        </td>
    </tr>
</table>

<!-- Footer -->
<div class="footer">
    <p style="font-weight: 600; color: var(--primary-color);">PRECIO UNO - Validación de Guía de Remisión</p>
    <p>Documento generado automáticamente - {{ date('d/m/Y H:i') }}</p>
</div>

</body>

</html>
