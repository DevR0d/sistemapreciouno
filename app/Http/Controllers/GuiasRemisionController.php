<?php

namespace App\Http\Controllers;

use App\Models\Guiasderemision;
use Illuminate\Http\Request;
use Exception;

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
                'numerotrasladotim'=> 'required',
                'motivotraslado' => 'required',
                'pesobrutototal' => 'required',
                'volumenproducto' => 'required',
                'numerobultopallet' => 'required',
                'observaciones' => 'nullable',
                'idconductor' => 'required',
                'idtipoempresa' => 'required',
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
                "observaciones" => $validated['observaciones'],
                "idconductor" => $validated['idconductor'],
                "idtipoempresa" => $validated['idtipoempresa'],
            ]);
            if (!$guiasremision["success"]) {
                throw new Exception($guiasremision["message"]);
            }
            // Si la inserción fue exitosa, puedes devolver una respuesta adecuada

            return response()->json([
                'success' => true,
                'message' => $guiasremision["message"],
                'data' => $guiasremision["data"]
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la guía de remisión: '.$ex->getMessage(),
                'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
            ], 500);
        }
    }
}
