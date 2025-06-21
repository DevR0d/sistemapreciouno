<?php

namespace App\Http\Controllers;

use App\Livewire\Usuarios\Gestionusuario;
use App\Models\User;
use App\Models\Gestionusuarios;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    public function validarLogin(Request $request)
    {

        global $success, $message, $idrol;

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {

            if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
                $modeloUsuario = new User();
                $usuario = $modeloUsuario->existeusuario($validated['email']);
                if ($usuario["data"] !== null) {
                    // Guardar en sesión personalizada
                    session(['usuariologeado' => $usuario]);
                }
                $success = true;
                $message = "OK";
                $idrol = $usuario["data"][0]["idrol"];
            } else {
                $success = false;
                $message = "Las Credenciales son incorrectas";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'idrol' => $idrol,
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error en iniciar sesion: ' . $ex->getMessage(),
                'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
            ], 500);
        }
    }
    public function verificarusuario(Request $request)
    {
        try {
            $validated = $request->validate([
                "id" => "nullable",
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'idrol' => 'required'
            ]);

            $gestionusuario = new User ();
            if ($validated['id'] === null) {
                $usuario = $gestionusuario->insertarusuarios([
                    "name" => $validated['name'],
                    "email" => $validated['email'],
                    "password" => $validated['password'],
                    "idrol" => $validated['idrol']
                ]);
            } else {
                $usuario = $gestionusuario->editarusuario([
                    "id" => $validated['id'],
                    "name" => $validated['name'],
                    "email" => $validated['email'],
                    "password" => $validated['password'],
                    "idrol" => $validated['idrol']
                ]);
            }

            if (!$usuario["success"]) {
                throw new Exception($usuario["message"]);
            }

            return response()->json([
                'success' => true,
                'message' => $usuario["message"],
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar los datos: ' . $ex->getMessage(),
                'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
            ], 500);
        }
    }

    // Para registrar el usuario
    // public function registrarusuario(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|email|unique:users,email',
    //             'password' => 'required|min:6',
    //             'idrol' => 'required|integer'
    //         ]);

    //         // Encriptar la contraseña antes de guardar
    //         $validated['password'] = bcrypt($validated['password']);

    //         $modelousuario = new Gestionusuarios();
    //         if ($validated['id'] === null) {
    //             $usuario = $modelousuario->insertarusuarios([
    //                 "name" => $validated['name'],
    //                 "email" => $validated['email'],
    //                 "password" => $validated['password'],
    //                 "idrol" => $validated['idrol']
    //             ]);
    //         } else {
    //             $usuario = $modelousuario->editarusuarios([
    //                 "id" => $validated['id'],
    //                 "name" => $validated['name'],
    //                 "email" => $validated['email'],
    //                 "password" => $validated['password'],
    //                 "idrol" => $validated['idrol']
    //             ]);
    //         }

    //         if (!$usuario["success"]) {
    //             throw new Exception($usuario["message"]);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => $usuario["message"],
    //             'data' => $usuario["data"]
    //         ]);
    //     } catch (\Exception $ex) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al registrar el usuario: ' . $ex->getMessage(),
    //             'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
    //         ], 500);
    //     }
    // }


    public function eliminarusuario(Request $request)
    {
        try {
            $validated = $request->validate([
                "id" => "nullable",
            ]);

            $gestionusuario = new User();
            $usuario = $gestionusuario->editarusuarios([
                "id" => $validated['id'],
                "estado" => "Eliminado"
            ]);

            if (!$usuario["success"]) {
                throw new Exception($usuario["message"]);
            }

            return response()->json([
                'success' => true,
                'message' => "Eliminado correctamente",
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario: ' . $ex->getMessage(),
                'error_details' => env('APP_DEBUG') ? $ex->getTrace() : null
            ], 500);
        }
    }
}
