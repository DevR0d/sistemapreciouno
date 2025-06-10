<?php

namespace App\Livewire;

use App\Models\Conductores;
use App\Models\Guiasderemision;
use App\Models\TipoEmpresa;
use Livewire\Attributes\On;
use Livewire\Component;

class Guiasremisionadministrador extends Component
{
    #[On('listarGuiasRemisionDesdeJS')]
    public function listar() {}

    public function render() {
        $modeloguiaremision = new Guiasderemision();
        $data = $modeloguiaremision->mostrarguiasderemision();

        // Obtener vehículos y conductores activos (nuevo)
        $conductores = Conductores::where('estado', 'activo')->get();
        $tipoempresa = TipoEmpresa::where('estado', 'activo')->get();

        return view('livewire.guiasremisionadministrador', [
            'data' => $data["data"] == null ? [] : $data["data"],
            'conductores' => $conductores,
            'tipoempresa' => $tipoempresa,
        ]);
    }
//    public function render()
//    {
//        return view('livewire.guiasremisionadministrador');
//    }
}
