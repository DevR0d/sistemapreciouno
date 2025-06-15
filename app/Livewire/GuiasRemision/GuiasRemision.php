<?php

namespace App\Livewire\GuiasRemision;

use App\Models\Conductores;
use App\Models\Guiasderemision;
use App\Models\TipoEmpresa;
use Livewire\Component;
use Livewire\Attributes\On;

//nombre de la clase de Livewire en HTTP lo demas es del modelo

class GuiasRemision extends Component
{
    public $idtipoempresaSeleccionada;
    public $razonsocial;
    public $ruc;
    public $direccion;
    public $provincia;
    public $departamento;
    public $ubigeo;
    public $codigoestablecimiento;

    #[On('listarGuiasRemisionDesdeJS')]
    public function listar() {}

    public function updatedIdtipoempresaSeleccionada($id)
    {
        $empresa = TipoEmpresa::where('idtipoempresa', $id)->first();
        if ($empresa) {
            $this->razonsocial = $empresa->razonsocial;
            $this->ruc = $empresa->ruc;
            $this->direccion = $empresa->direccion;
            $this->provincia = $empresa->provincia;
            $this->departamento = $empresa->departamento;
            $this->ubigeo = $empresa->ubigeo;
            $this->codigoestablecimiento = $empresa->codigoestablecimiento;
        } else {
            $this->razonsocial = '';
            $this->ruc = '';
            $this->direccion = '';
            $this->provincia = '';
            $this->departamento = '';
            $this->ubigeo = '';
            $this->codigoestablecimiento = '';
        }
    }

    public function render() {
        $modeloguiaremision = new Guiasderemision();
        $data = $modeloguiaremision->mostrarguiasderemision();

        $conductores = Conductores::where('estado', 'activo')->get();
        $tipoempresa = TipoEmpresa::where('estado', 'activo')->get();

        return view('livewire.guias-remision.guias-remision', [
            'data' => $data["data"] ?? [],
            'conductores' => $conductores,
            'tipoempresa' => $tipoempresa,
        ]);
    }
}