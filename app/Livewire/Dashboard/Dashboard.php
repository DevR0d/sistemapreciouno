<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalGuiasEmitidas;
    public $totalRevisiones;
    public $guiasSinDanio;
    public $guiasConDanio;
    public $ultimasGuias;
    public $guiascondiscrepancias;
    public $fechas;
    public $datosSinDiscrepancias;
    public $datosConDiscrepancias;
    public $productosConDiscrepancias;


    public function mount()
    {
        $this->totalGuiasEmitidas = DB::table('guiaremision')
            ->where('estado', '!=', 'Eliminado')
            ->count();

        $this->totalRevisiones = DB::table('guiaremision')
            ->where('estado', '=', 'Confirmado')
            ->count();

        $this->guiasSinDanio = DB::table('guiaremision as g')
            ->join('validacion as v', 'g.idguia', '=', 'v.idguia')
            ->where('v.idtipocondicion', 1)
            ->where('g.estado', '!=', 'Eliminado')
            ->distinct()
            ->count('g.idguia');

        $this->guiasConDanio = DB::table('guiaremision as g')
            ->join('validacion as v', 'g.idguia', '=', 'v.idguia')
            ->where('v.idtipocondicion', 2)
            ->where('g.estado', '!=', 'Eliminado')
            ->distinct()
            ->count('g.idguia');

        $this->ultimasGuias = DB::table('guiaremision')
            ->select(DB::raw('DATE(fechaemision) as fecha'), DB::raw('COUNT(*) as total'))
            ->where('estado', '!=', 'Eliminado')
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->limit(15)
            ->get();

        $this->guiascondiscrepancias = DB::table('guiaremision as g')
            ->select(
                'g.codigoguia',
                DB::raw('COUNT(DISTINCT d.idproducto) as cantidad_productos'),
                DB::raw('SUM(CASE WHEN v.idtipocondicion = 2 THEN 1 ELSE 0 END) as cantidad_discrepancias')
            )
            ->leftJoin('detalleguia as d', 'd.idguia', '=', 'g.idguia')
            ->leftJoin('validacion as v', 'v.idguia', '=', 'g.idguia')
            ->where('g.estado', '!=', 'Eliminado') // excluye guías eliminadas
            ->groupBy('g.codigoguia')
            ->having('cantidad_discrepancias', '>', 0) // solo guías con discrepancias
            ->limit(10)
            ->get();

        $datosPorFecha = DB::table('guiaremision as g')
            ->selectRaw('DATE(g.fechaemision) as fecha')
            ->selectRaw('
        SUM(CASE WHEN v.idtipocondicion = 1 THEN 1 ELSE 0 END) as sin_discrepancia,
        SUM(CASE WHEN v.idtipocondicion = 2 THEN 1 ELSE 0 END) as con_discrepancia,
        COUNT(DISTINCT CASE WHEN v.idvalidacion IS NULL THEN g.idguia END) as faltantes
    ')
            ->leftJoin('validacion as v', 'g.idguia', '=', 'v.idguia')
            ->where('g.estado', '!=', 'Eliminado')
            ->groupByRaw('DATE(g.fechaemision)')
            ->orderByRaw('DATE(g.fechaemision) asc')
            ->limit(7)
            ->get();

        $this->labelsResumen = [];
        $this->datosDiscrepancias = [];
        $this->datosSinDiscrepancias = [];
        $this->datosFaltantes = [];

        foreach ($datosPorFecha as $row) {
            $this->labelsResumen[] = \Carbon\Carbon::parse($row->fecha)->format('d-M');
            $this->datosDiscrepancias[] = (int)$row->con_discrepancia;
            $this->datosSinDiscrepancias[] = (int)$row->sin_discrepancia;
            $this->datosFaltantes[] = (int)$row->faltantes;
        }


        //pruebita
        // Fechas base (últimos 7 días con guías emitidas)
        $fechasBase = DB::table('guiaremision')
            ->selectRaw('DATE(fechaemision) as fecha')
            ->where('estado', '!=', 'Eliminado')
            ->groupByRaw('DATE(fechaemision)')
            ->orderByRaw('DATE(fechaemision) asc')
            ->limit(7)
            ->pluck('fecha');

        // Guías sin discrepancias por fecha
        $sinDiscrepancias = DB::table('guiaremision as g')
            ->join('validacion as v', 'g.idguia', '=', 'v.idguia')
            ->where('v.idtipocondicion', 1)
            ->where('g.estado', '!=', 'Eliminado')
            ->select(DB::raw('DATE(g.fechaemision) as fecha'), DB::raw('COUNT(DISTINCT g.idguia) as total'))
            ->groupBy('fecha')
            ->pluck('total', 'fecha');

        // Guías con discrepancias por fecha
        $conDiscrepancias = DB::table('guiaremision as g')
            ->join('validacion as v', 'g.idguia', '=', 'v.idguia')
            ->where('v.idtipocondicion', 2)
            ->where('g.estado', '!=', 'Eliminado')
            ->select(DB::raw('DATE(g.fechaemision) as fecha'), DB::raw('COUNT(DISTINCT g.idguia) as total'))
            ->groupBy('fecha')
            ->pluck('total', 'fecha');

        // Preparar arrays alineados por fecha
        $this->fechas = [];
        $this->datosSinDiscrepancias = [];
        $this->datosConDiscrepancias = [];

        foreach ($fechasBase as $fecha) {
            $this->fechas[] = \Carbon\Carbon::parse($fecha)->format('d-M');
            $this->datosSinDiscrepancias[] = $sinDiscrepancias[$fecha] ?? 0;
            $this->datosConDiscrepancias[] = $conDiscrepancias[$fecha] ?? 0;
        }
        //productos con discrepancias
        $this->productosConDiscrepancias = DB::table('validacion as v')
            ->join('detalleguia as d', function ($join) {
                $join->on('v.idguia', '=', 'd.idguia')
                    ->on('v.idproducto', '=', 'd.idproducto');
            })
            ->join('productos as p', 'v.idproducto', '=', 'p.idproducto')
            ->join('guiaremision as g', 'g.idguia', '=', 'v.idguia')
            ->select(
                'p.codigoproducto as codproducto',
                'p.nombre',
                'v.estado',
                'd.cantrecibida',
                'v.cantrecibidarevision',
                'g.fechaemision as fecha'
            )
            ->where('v.idtipocondicion', '!=', 1) // sólo discrepancias
            ->where('g.estado', '!=', 'Eliminado')
            ->limit(30)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }
}
