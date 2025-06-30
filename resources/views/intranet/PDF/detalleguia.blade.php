<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Guía de Remisión</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            margin: 20px;
        }

        .header,
        .footer,
        .content,
        .transport {
            width: 100%;
            border-collapse: collapse;
        }

        .header td,
        .content td,
        .content th,
        .transport td {
            border: 1px solid #000;
            padding: 4px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .bold {
            font-weight: bold;
        }

        .no-border td {
            border: none;
        }

        .section-title {
            margin-top: 10px;
            font-weight: bold;
            background: #eee;
            padding: 4px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

<table class="header">
    <tr>
        <td rowspan="3" style="width: 25%; text-align: center;">
            <strong>TOTTUS</strong><br>
            <small>{{ $guia->razonsocialguia ?? 'N/A' }}</small><br>
            R.U.C. Nº {{ $tipoempresa->ruc ?? 'N/A' }}
        </td>
        <td class="title" colspan="2">GUÍA DE REMISIÓN ELECTRÓNICA</td>
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

{{--<div class="section-title text-center">DATOS GENERALES</div>--}}
{{--<table class="content">--}}
{{--    <tr>--}}
{{--        <td><strong>Dirección Partida:</strong> {{ $guia->direccionpartida ?? 'N/A' }}</td>--}}
{{--        <td><strong>Ubigeo:</strong> {{ $guia->ubigeopartida ?? '150118' }}</td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td><strong>Dirección Llegada:</strong> {{ $guia->direccionllegada ?? 'N/A' }}</td>--}}
{{--        <td><strong>Ubigeo:</strong> {{ $guia->ubigeollegada ?? 'N/A' }}</td>--}}
{{--    </tr>--}}
{{--</table>--}}

<div class="section-title text-center">DATOS GENERALES</div>
<table class="content">
    <tr>
        <td><strong>N° Guía:</strong> {{ $guia->codigoguia ?? 'N/A' }}</td>
        <td><strong>N° TIM:</strong> {{ $guia->numerotrasladotim ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Fecha Emisión:</strong> {{ $guia->fechaemision ?? 'N/A' }}</td>
        <td><strong>Hora Emisión:</strong> {{ $guia->horaemision ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Razón Social (Cliente):</strong> {{ $guia->razonsocialguia ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Motivo del traslado:</strong> {{ $guia->motivotraslado ?? 'N/A' }}</td>
        <td><strong>Peso Total (kg):</strong> {{ $guia->pesobrutototal ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Volumen (m³):</strong> {{ $guia->volumenproducto ?? 'N/A' }}</td>
        <td><strong>N° Bultos:</strong> {{ $guia->numerobultopallet ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Observaciones:</strong> {{ $guia->observaciones ?? 'Ninguna' }}</td>
    </tr>
</table>

<div class="section-title text-center">DATOS DE LA EMPRESA</div>
<table class="content">
    <tr>
        <td colspan="2"><strong>Razón Social:</strong> {{ $tipoempresa->razonsocial ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>RUC:</strong> {{ $tipoempresa->ruc ?? 'N/A' }}</td>
        <td><strong>Cód. Establecimiento:</strong> {{ $tipoempresa->codigoestablecimiento ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Dirección:</strong> {{ $tipoempresa->direccion ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Departamento:</strong> {{ $tipoempresa->departamento ?? 'N/A' }}</td>
        <td><strong>Provincia:</strong> {{ $tipoempresa->provincia ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Ubigeo:</strong> {{ $tipoempresa->ubigeo ?? 'N/A' }}</td>
    </tr>
</table>


<div class="section-title text-center">UNIDAD DE TRANSPORTE DEL CONDUCTOR</div>
<table class="transport">
    <tr>
        <td><strong>Empresa:</strong> {{ $transporte->nombre_razonsocial ?? 'N/A' }}</td>
        <td><strong>RUC:</strong> {{ $transporte->ruc_transportista ?? 'N/A' }}</td>
        <td><strong>Modalidad:</strong> {{ $transporte->modalidadtraslado ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Conductor:</strong> {{ $conductor->nombre ?? 'N/A' }}</td>
        <td><strong>DNI:</strong> {{ $conductor->dni ?? 'N/A' }}</td>
        <td><strong>Placa:</strong> {{ $vehiculo->placa ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Placa secundaria:</strong> {{ $vehiculo->placasecundaria ?? 'N/A' }}</td>
        <td><strong>Estado del vehículo:</strong> {{ $vehiculo->estado ?? 'N/A' }}</td>
        <td><strong>Estado del conductor:</strong> {{ $conductor->estado ?? 'N/A' }}</td>
    </tr>
</table>

<div class="section-title text-center">PRODUCTOS TRANSPORTADOS</div>
<table class="content">
    <thead>
    <tr>
        <th>EAN / SKU</th>
        <th>DESCRIPCION</th>
        <th>UNIDAD</th>
        <th class="text-center">CANTIDAD</th>
    </tr>
    </thead>
    <tbody>
    @forelse($detalleguia as $item)
        @php $item = (object)$item; @endphp
        <tr>
            <td class="text-center">{{ $item->codproducto ?? 'N/A' }}</td>
            <td>{{ $item->producto ?? 'Sin descripción' }}</td>
            <td class="text-center">N/U</td>
            <td class="text-center">{{ number_format($item->cantidad ?? 0, 0) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No se encontraron productos</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="section-title">DATOS ADICIONALES</div>
<table class="content">
    <tr>
        <td><strong>Peso bruto total (kg):</strong> {{ $guia->pesobrutototal ?? 'N/A' }}</td>
        <td><strong>Volumen total (m³):</strong> {{ $guia->volumenproducto ?? 'N/A' }}</td>
        <td><strong>Bultos:</strong> {{ $guia->numerobultopallet ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td colspan="3"><strong>Observaciones:</strong> {{ $guia->observaciones ?? 'Ninguna' }}</td>
    </tr>
</table>

</body>

</html>
