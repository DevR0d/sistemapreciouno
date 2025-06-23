<?php

namespace App\Http\Controllers;

use App\Models\Guiasderemision;
use App\Models\Conductores;
use App\Models\TipoEmpresa;
use App\Models\Transporte;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReporteController extends Controller
{
    public function generarPdfGuia($id)
    {
        $modelo = new Guiasderemision();
        $modelConductor = new Conductores();
        $modelTransporte = new Transporte();
        $modelVehiculo = new Vehiculo();
        $modelEmpresa = new TipoEmpresa();

        // Obtener la guía
        $guiaResult = $modelo->mostrarguiasderemision(['idguia' => $id]);
        if (!$guiaResult['success'] || empty($guiaResult['data'])) {
            abort(404, 'Guía de remisión no encontrada');
        }
        $guia = (object)$guiaResult['data'][0];

        // Obtener detalle de productos (detalleguia)
        $detalleguiaData = DB::table('v_detalleguia')
            ->where('idguia', $id)
            ->get()
            ->map(function ($item) {
                return (object)[
                    'codproducto' => $item->codproducto ?? 'N/A',
                    'producto' => $item->producto ?? 'Sin descripción',
                    'cantidad' => $item->cantrecibidarevision ?? $item->cant ?? 0,
                ];
            });

        // Obtener conductor
        $conductorData = $modelConductor->mostrarconductores(['idguia' => $id]);
        $conductor = !empty($conductorData['data']) ? (object)$conductorData['data'][0] : (object)[];

        // Obtener transporte
        $transporteData = $modelTransporte->mostrartransporte(['idguia' => $id]);
        $transporte = !empty($transporteData['data']) ? (object)$transporteData['data'][0] : (object)[];

        // Obtener vehículo
        $vehiculoData = $modelVehiculo->mostravehiculo(['idguia' => $id]);
        $vehiculo = !empty($vehiculoData['data']) ? (object)$vehiculoData['data'][0] : (object)[];

        // Obtener tipo empresa
        $tipoempresaData = $modelEmpresa->mostrartipoempresa(['idguia' => $id]);
        $tipoempresa = !empty($tipoempresaData['data']) ? (object)$tipoempresaData['data'][0] : (object)[];

        // Preparar datos para la vista
        $datos = [
            'guia' => $guia,
            'detalleguia' => $detalleguiaData,
            'conductor' => $conductor,
            'transporte' => $transporte,
            'vehiculo' => $vehiculo,
            'tipoempresa' => $tipoempresa,
        ];

        // Generar PDF
        $pdf = PDF::loadView('intranet.PDF.detalleguia', $datos)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Guia_' . $guia->codigoguia . '_' . date('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}
