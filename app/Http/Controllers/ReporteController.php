<?php

namespace App\Http\Controllers;

use App\Models\Conductores;
use App\Models\Guiasderemision;
use App\Models\Productos;
use App\Models\TipoEmpresa;
use App\Models\Transporte;
use App\Models\ValidacionGuia;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use PDF;

class ReporteController extends Controller
{
    public function generarPdfGuia($id)
    {
        $modelo = new Guiasderemision();

        // Obtener la guía por ID
        $guiaResult = $modelo->mostrarguiasderemision(['idguia' => $id]);
        if (!$guiaResult['success'] || empty($guiaResult['data'])) {
            abort(404, 'Guía de remisión no encontrada');
        }

        $guia = (object)$guiaResult['data'][0]; // Convertir a objeto para acceder con ->

        // Obtener el detalle de la guía
        $detalleResult = $modelo->mostrardetalleguia(['idguia' => $id]);
        $detalleguia = $detalleResult['data'] ?? [];

        // Obtener datos del conductor (asumiendo que v_guiaremision ya incluye estos datos)
        $conductor = (object)[
            'nombre' => $guia->nombre_conductor ?? 'N/A',
            'dni' => $guia->dni_conductor ?? 'N/A',
            'estado' => $guia->estado_conductor ?? 'N/A'
        ];

        // Obtener datos de la empresa transportista (asumiendo que v_guiaremision ya incluye estos datos)
        $tipoempresa = (object)[
            'razonsocial' => $guia->razonsocial_empresa ?? 'N/A',
            'ruc' => $guia->ruc_empresa ?? 'N/A',
            'estado' => $guia->estado_empresa ?? 'N/A'
        ];

        // Preparar datos para la vista
        $datos = [
            'guia' => $guia,
            'conductor' => $conductor,
            'tipoempresa' => $tipoempresa,
            'detalleguia' => $detalleguia,
        ];

        // Generar PDF usando DomPDF
        $pdf = PDF::loadView('intranet.PDF.detalleguia', $datos)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Guia #' . $guia->idguia . '_' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    public function generarPdfValidacion($id)
    {
        // Instancia del modelo Guiasderemision
        $modelo = new Guiasderemision();

        // Obtener la guía
        $guiaResult = $modelo->mostrarguiasderemision(['idguia' => $id]);
        if (!$guiaResult['success'] || empty($guiaResult['data'])) {
            abort(404, 'Guía de remisión no encontrada');
        }
        $guia = (object)$guiaResult['data'][0];

        // Obtener detalle de productos
        $detalleResult = $modelo->mostrardetalleguia(['idguia' => $id]);
        $detalleguia = $detalleResult['data'] ?? [];

        // Obtener datos del transporte usando el modelo Transporte
        $transporte = (new Transporte())->mostrartransporte(['idguia' => $id]);

        // Obtener datos del conductor usando el modelo Conductores
        $conductor = (new Conductores())->mostrarconductores(['idguia' => $id]);

        // Obtener datos del vehículo usando el modelo Vehiculo
        $vehiculo = (new Vehiculo())->mostravehiculo(['idguia' => $id]);

        // Obtener datos de la empresa usando el modelo TipoEmpresa
        $tipoempresa = (new TipoEmpresa())->mostrartipoempresa(['idguia' => $id]);

        // Obtener validación de productos
        $validacion = (new ValidacionGuia())->mostrarvalidacionguia(['idguia' => $id]);

        // Obtener productos agrupados por condición
        $porCondicion = (new ValidacionGuia())->obtenerProductosPorCondicion($id);
//        $porCondicion = $validacion->obtenerProductosPorCondicion($id);
        $productosBuenos = $porCondicion['success'] ? $porCondicion['data']['productosBuenos'] : [];
        $productosRegulares = $porCondicion['success'] ? $porCondicion['data']['productosRegulares'] : [];
        $productosDanados = $porCondicion['success'] ? $porCondicion['data']['productosDañados'] : [];
        $productosSinCondicion = $porCondicion['success'] && isset($porCondicion['data']['productosSinCondicion']) ? $porCondicion['data']['productosSinCondicion'] : [];

        // Calcular el total de productos validados
        $totalValidados = collect($productosBuenos)->sum('cantidad') +
            collect($productosRegulares)->sum('cantidad') +
            collect($productosDanados)->sum('cantidad');

        // Preparar los datos para la vista PDF
        $datos = [
            'guia' => $guia,
            'detalleguia' => $detalleguia,
            'transporte' => $transporte,
            'conductor' => $conductor,
            'vehiculo' => $vehiculo,
            'tipoempresa' => $tipoempresa,
            'validacion' => $validacion,
            'productosBuenos' => $productosBuenos,
            'productosRegulares' => $productosRegulares,
            'productosDanados' => $productosDanados,
            'productosSinCondicion' => $productosSinCondicion,
            'totalValidados' => $totalValidados,
        ];

        // Generar el PDF
        $pdf = PDF::loadView('intranet.PDF.validacionguia', $datos)->setPaper('A4', 'portrait');

        // Descargar el archivo PDF
        return $pdf->download('ValidacionGuia_' . $guia->idguia . '.pdf');
    }
}
