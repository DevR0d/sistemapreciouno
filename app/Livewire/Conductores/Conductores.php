<?php

namespace App\Livewire\Conductores;
use Livewire\Component;

class Conductores extends Component
{
    #[On('listarconductoresDesdeJS')]
    public function listar() {}

    public function render()
    {
        $modeloconductores = new \App\Models\Conductores();
        $data = $modeloconductores->mostraproducto();
        return view('livewire.conductores.conductores', [
            'data' => $data["data"] == null ? [] : $data["data"]
        ]);

//        return view('livewire.conductores.conductores');
    }
//    public function render()
//    {
//        return view('livewire.conductores.conductores');
//    }
}
