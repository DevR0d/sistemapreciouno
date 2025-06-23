<?php

namespace App\Models;

use App\Models\Global\GlobalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ValidacionGuia extends Model
{
    protected $table = 'validacion'; // Especifica el nombre_razonsocial exacto de la tabla
    protected $primaryKey = 'idvalidacion'; // Si tu clave primaria no se llama "id"
    public $timestamps = false; // Desactiva timestamps si tu tabla no tiene created_at / updated_at

    // Opcional: si quieres proteger o permitir ciertas columnas
    protected $fillable = [
        'cantrecibidarevision',
        'modalidadtraslado',
        'idguia',
        'idproducto',
        'idtipocondicion',
    ];

    public function mostrarvalidacionguia(array $parametros = []): array
    {
        //        $query = DB::table('v_transporte');
        //        $query = DB::table('v_validacion')->where('estado', '!=', 'Eliminado');
        $query = DB::table('v_validacion')
            ->leftJoin('tipocondicion', 'v_validacion.idtipocondicion', '=', 'tipocondicion.idtipocondicion')
            ->select('v_validacion.*', 'tipocondicion.nombretipocondicion')
            ->where('v_validacion.estado', '!=', 'Eliminado');

        // Filtros condicionales
        if (isset($parametros['idvalidacion'])) {
            $query->where('idvalidacion', $parametros['idvalidacion']);
        }

        if (isset($parametros['cantrecibidarevision'])) {
            $query->where('cantrecibidarevision', $parametros['cantrecibidarevision']);
        }

        if (isset($parametros['modalidadtraslado'])) {
            $query->where('modalidadtraslado', $parametros['modalidadtraslado']);
        }

        if (isset($parametros['idguia'])) {
            $query->where('idguia', $parametros['idguia']);
        }

        if (isset($parametros['idproducto'])) {
            $query->where('idproducto', $parametros['idproducto']);
        }

        if (isset($parametros['idtipocondicion'])) {
            $query->where('idtipocondicion', $parametros['idtipocondicion']);
        }

        // Verificar si se pide paginación
        if (isset($parametros['paginado']) && $parametros['paginado'] === true) {
            $porPagina = $parametros['porPagina'] ?? 10;
            $validacion = $query->orderByDesc('idvalidacion')->paginate($porPagina);

            return GlobalModel::returnArray(
                $validacion->count() > 0,
                $validacion->count() === 0 ? "No hay validaciones registradas" : "OK",
                $validacion // Retorna el paginador
            );
        }

        // Si no hay paginado, obtener todo
        $validacion = $query->get()->map(fn($item) => (array) $item)->toArray();
        return GlobalModel::returnArray(
            !empty($validacion),
            empty($validacion) ? "No hay validaciones registradas" : "OK",
            $validacion
        );
    }

    // Metodo para obtener productos por condicion
//    public function obtenerProductosPorCondicion($idguia)
//    {
//        $productosBuenos = DB::table('v_detalleguia')
//            ->where('idguia', $idguia)
//            ->where('nombretipocondicion', 'BUENO')
//            ->get();
//
//        $productosRegulares = DB::table('v_detalleguia')
//            ->where('idguia', $idguia)
//            ->where('nombretipocondicion', 'REGULAR')
//            ->get();
//
//        $productosDanados = DB::table('v_detalleguia')
//            ->where('idguia', $idguia)
//            ->where('nombretipocondicion', 'DAÑADO')
//            ->get();
//
//        $productosSinCondicion = DB::table('v_detalleguia')
//            ->where('idguia', $idguia)
//            ->whereNull('nombretipocondicion')
//            ->get();
//
//        return [
//            'success' => true,
//            'data' => [
//                'productosBuenos' => $productosBuenos,
//                'productosRegulares' => $productosRegulares,
//                'productosDañados' => $productosDanados,
//                'productosSinCondicion' => $productosSinCondicion,
//            ]
//        ];
//    }

    public function obtenerProductosPorCondicion($idguia)
    {
        $productos = DB::table('v_detalleguia')
            ->where('idguia', $idguia)
            ->get();

        $agrupados = [
            'productosBuenos' => [],
            'productosDañados' => [],
            'productosRegulares' => [],
            'productosSinCondicion' => [],
        ];

        foreach ($productos as $prod) {
            $item = (object)[
                'idproducto' => $prod->idproducto,
                'codproducto' => $prod->codproducto,
                'producto' => $prod->producto,
                'cantidad' => $prod->cantrecibidarevision ?? $prod->cant ?? 0, // <-- fix aquí
                'nombretipocondicion' => $prod->nombretipocondicion,
                'observaciones' => $prod->observaciones ?? null,
            ];

            switch (strtolower($prod->nombretipocondicion ?? '')) {
                case 'bueno':
                    $agrupados['productosBuenos'][] = $item;
                    break;
                case 'dañado':
                    $agrupados['productosDañados'][] = $item;
                    break;
                case 'regular':
                    $agrupados['productosRegulares'][] = $item;
                    break;
                default:
                    $agrupados['productosSinCondicion'][] = $item;
            }
        }

        return [
            'success' => true,
            'data' => $agrupados,
        ];
    }
}
