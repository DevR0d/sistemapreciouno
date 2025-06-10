<?php

namespace App\Http\Controllers;

use App\Models\Guiasderemision;
use Illuminate\Http\Request;
use Exception;

use App\Models\Conductores;
use App\Models\TipoEmpresa;
use App\Models\Productos;


class GuiasRemisionController extends Controller
{
    public function registrarguiaremision(Request $request)
    {
        try {
            $validated = $request->validate([
                //                'idguia' => 'nullable',
                'codigoguia' => 'required',
                'fechaemision' => 'required',
                'horaemision' => 'required',
                'razonsocialguia' => 'required',
                'numerotrasladotim' => 'required',
                'motivotraslado' => 'required',
                'pesobrutototal' => 'required',
                'volumenproducto' => 'required',
                'numerobultopallet' => 'required',
                'observaciones' => 'nullable',
                'idconductor' => 'required',
                'idtipoempresa' => 'required',
                "productos" => 'required|array',
            ]);

            $modeloguiaremision = new Guiasderemision();
            $guiasremision = $modeloguiaremision->insertarguiaremision([
                "codigoguia" => $validated['codigoguia'],
                "fechaemision" => $validated['fechaemision'],
                "horaemision" => $validated['horaemision'],
                "razonsocialguia" => $validated['razonsocialguia'],
                "numerotrasladotim" => $validated['numerotrasladotim'],
                "motivotraslado" => $validated['motivotraslado'],
                "pesobrutototal" => $validated['pesobrutototal'],
                "volumenproducto" => $validated['volumenproducto'],
                "numerobultopallet" => $validated['numerobultopallet'],
                "observaciones" => $validated['observaciones'] === null ? "" : $validated['observaciones'],
                "idconductor" => $validated['idconductor'],
                "idtipoempresa" => $validated['idtipoempresa'],
            ]);
            if ($guiasremision["data"] === null) {
                throw new Exception($guiasremision["message"]);
            }

            foreach ($validated['productos'] as $p) {
                $detalleguiasremision = $modeloguiaremision->insertardetalleguiaremision([
                    "idguia" => $guiasremision["data"][0]['idguia'],
                    "idproducto" => $p["idproducto"],
                    "condicion" => $p["estado"],
                    "cant" => $p["cantidad"]
                ]);

                if (!$detalleguiasremision["success"]) {
                    throw new \Exception("Error al registrar el detalleGuia");
                }
            }

            return response()->json([
                'success' => true,
                'message' => $guiasremision["message"],
                'data' => $guiasremision["data"]
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la guía de remisión: ' . $ex->getMessage(),
                'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
            ], 500);
        }
    }

//    public function vistaguias()
//    {
//        $conductores = Conductores::all();
//        $tipoempresa = TipoEmpresa::all();
//        $productos = Productos::all();
//
//        return view('intranet.prevencionistas.addguiasremision', compact('conductores', 'tipoempresa', 'productos'));
//    }

    public function vistaguias(Request $request)
    {
        $idguia = $request->query('idguia');

        $conductores = Conductores::all();
        $tipoempresa = TipoEmpresa::all();
        $productos = Productos::all();
//        $transportes = Transportistas::all(); // si lo usas también

        $guia = null;
        if ($idguia) {
            $modeloguiaremision = new Guiasderemision();
            $guiaData = $modeloguiaremision->mostrarguiaremisionporid($idguia); // Asegúrate que retorne la guía como array
            $guia = $guiaData['data'][0] ?? null;
        }

        return view('intranet.prevencionistas.addguiasremision', compact(
            'conductores', 'tipoempresa', 'productos', 'guia'
        ));
    }

    public function eliminarguia(Request $request)
    {
        try {
            $validated = $request->validate([
                "idguia" => "nullable",
            ]);

            $modeloguiaremision = new Guiasderemision();
            $guiasremision = $modeloguiaremision->editarguia([
                "idguia" => $validated['idguia'],
                "estado" => "Eliminado"
            ]);

            if (!$guiasremision["success"]) {
                throw new Exception($guiasremision["message"]);
            }

            return response()->json([
                'success' => true,
                'message' => "Eliminado correctamente",
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la guia: ' . $ex->getMessage(),
                'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
            ], 500);
        }
    }
}
