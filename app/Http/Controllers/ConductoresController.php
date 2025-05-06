<?php

namespace App\Http\Controllers;

use App\Models\Conductores;
use Illuminate\Http\Request;

class ConductoresController extends Controller
{
    //Para registrar el conductor
    public function registrarConductor(Request $request) {
        try{
            $validated = $request->validate([
                'nombre' => 'required',
                'sku' => 'required',
                'estado' => 'required',
                'fecharegistro' => 'required'
            ]);

            $modeloconductor = new Conductores();
            $conductor = $modeloconductor->insertarconductores($validated);

            if(!$conductor["success"]){
                throw new Exception($conductor["message"]);
            }

            return response()->json([
                'success' => true,
                'message' => $conductor["message"],
                'data' => $conductor["data"]
            ]);
        }catch (\Exception $ex){
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el conductor: '.$ex->getMessage(),
                'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
            ], 500);
        }
    }
    //Para eliminar el conductor
    public function eliminarConductor($id)
    {
        try {
            $modeloconductor = new Conductors();
            $resultado = $modeloconductor->eliminarConductor($id);

            if(!$resultado["success"]){
                throw new Exception($resultado["message"]);
            }

            return response()->json([
                'success' => true,
                'message' => $resultado["message"]
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el Conductor: '.$ex->getMessage()
            ], 500);
        }
    }
}
