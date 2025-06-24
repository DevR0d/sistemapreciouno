<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación de Guía</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table td, .table th { border: 1px solid #000; padding: 4px; }
        .title { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 10px; }
        .section-title { background: #eee; font-weight: bold; padding: 4px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

<div class="title">REPORTE DE VALIDACIÓN DE GUÍA</div>

<table class="table">
    <tr>
        <td><strong>N° Guía:</strong> {{ $guia->codigoguia ?? 'N/A' }}</td>
        <td><strong>Fecha:</strong> {{ $guia->fechaemision ?? 'N/A' }}</td>
        <td><strong>Hora:</strong> {{ $guia->horaemision ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td colspan="3"><strong>Empresa Remitente:</strong> {{ $tipoempresa->razonsocial ?? 'N/A' }}</td>
    </tr>
</table>

<div class="section-title">DATOS DE TRANSPORTE</div>
<table class="table">
    <tr>
        <td><strong>Transportista:</strong> {{ $transporte->nombre_razonsocial ?? 'N/A' }}</td>
        <td><strong>RUC:</strong> {{ $transporte->ruc_transportista ?? 'N/A' }}</td>
        <td><strong>Modalidad:</strong> {{ $transporte->modalidadtraslado ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Conductor:</strong> {{ $conductor->nombre ?? 'N/A' }}</td>
        <td><strong>DNI:</strong> {{ $conductor->dni ?? 'N/A' }}</td>
        <td><strong>Placa:</strong> {{ $vehiculo->placa ?? 'N/A' }}</td>
    </tr>
</table>

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
        <h4>{{ ucfirst(strtolower($tipo)) }} ({{ count($items) }})</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Condición</th>
                <th>Observación</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                @php $item = (object)$item; @endphp
                <tr>
                    <td>{{ $item->codproducto ?? 'N/A' }}</td>
                    <td>{{ $item->producto ?? 'Sin descripción' }}</td>
                    <td class="text-center">{{ number_format($item->cantidad ?? 0, 2) }}</td>
                    <td class="text-center">{{ $item->nombretipocondicion ?? 'PENDIENTE' }}</td>
                    <td>{{ $item->observaciones ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endforeach

<div class="section-title">RESUMEN</div>
<table class="table">
    <tr>
        <td><strong>Total Validados:</strong> {{ number_format($totalValidados, 2) }}</td>
        <td colspan="2"><strong>Observaciones Generales:</strong> {{ $validacion->observaciones ?? 'Ninguna' }}</td>
    </tr>
</table>

</body>
</html>
