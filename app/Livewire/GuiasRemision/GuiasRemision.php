<?php

namespace App\Livewire\GuiasRemision;

use App\Models\Guiasderemision;
use App\Models\Vehiculo;
use App\Models\Conductores;
use Livewire\Component;
use Livewire\Attributes\On;

//nombre de la clase de Livewire en HTTP lo demas es del modelo
class GuiasRemision extends Component
{
    #[On('listarGuiasRemisionDesdeJS')]
    public function listar() {}

    public function render() {
//        $modeloguiaremision = new Guiasderemision();
//        $data = $modeloguiaremision->mostrarguiasderemision();
//        return view('livewire.guias-remision.guias-remision', [
//            'data' => $data["data"] == null ? [] : $data["data"]
//        ]);

        $modeloguiaremision = new Guiasderemision();
        // Obtener datos principales (sin cambiar tu lógica actual)
        $data = $modeloguiaremision->mostrarguiasderemision();

        // Obtener vehículos y conductores activos (nuevo)
        $vehiculos = Vehiculo::where('estado', 'activo')->get();
        $conductores = Conductores::where('estado', 'activo')->get();

        // Devolver vista con todos los datos necesarios
        return view('livewire.guias-remision.guias-remision', [
            'data' => $data["data"] == null ? [] : $data["data"],
            'vehiculos' => $vehiculos,
            'conductores' => $conductores
        ]);
    }

}
