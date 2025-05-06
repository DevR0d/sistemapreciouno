<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VistasIntranetController extends Controller
{
    public function vistalogin()
    {
        return view('auth.login');
    }

    public function vistadashboard()
    {
        return view('intranet.dashboard');
    }

    public function vistavehiculo()
    {
        return view('intranet.vehiculo');
    }

    public function vistaconductores()
    {
        return view('intranet.conductores');
    }

    public function vistausuarios()
    {
        return view('intranet.usuarios');
    }

    public function vistaproducto(){
        return view('intranet.productos');
    }

//    public function vistaguiasderemision(){
//        return view('intranet.guiasremision');
//    }

//sacha corregido
    public function vistaguiasderemision()
    {
        $vehiculos = \App\Models\Vehiculo::where('estado', 'activo')->get();
        $conductores = \App\Models\Conductores::where('estado', 'activo')->get();

        return view('intranet.guiasremision', compact('vehiculos', 'conductores'));
    }

    public function vistarevisionguias(){
        return view('intranet.revisionguias');
    }
}
