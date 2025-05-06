<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conductores extends Model
{
    protected $table = 'conductores'; // Especifica el nombre exacto de la tabla
    protected $primaryKey = 'idconductor'; // Si tu clave primaria no se llama "id"
    public $timestamps = false; // Desactiva timestamps si tu tabla no tiene created_at / updated_at

    // Opcional: si quieres proteger o permitir ciertas columnas
    protected $fillable = [
        'nombre',
        "dni",
    ];

    public function mostravehiculo(array $parametros = []): array {
        $query = DB::table('v_conductores');

        // Filtros condicionales
        if (isset($parametros['idconductor'])) {
            $query->where('idconductor', $parametros['idconductor']);
        }

        if (isset($parametros['nombre'])) {
            $query->where('nombre', $parametros['nombre']);
        }

        if (isset($parametros['dni'])) {
            $query->where('dni', $parametros['dni']);
        }

        // Verificar si se pide paginación
        if (isset($parametros['paginado']) && $parametros['paginado'] === true) {
            $porPagina = $parametros['porPagina'] ?? 10;
            $conductor = $query->orderByDesc('idconductor')->paginate($porPagina);

            return GlobalModel::returnArray(
                $conductor->count() > 0,
                $conductor->count() === 0 ? "No hay Conductores registrados" : "OK",
                $conductor // Retorna el paginador
            );
        }

        // Si no hay paginado, obtener todo
        $conductor = $query->get()->map(fn($item) => (array) $item)->toArray();
        return GlobalModel::returnArray(
            !empty($conductor),
            empty($conductor) ? "No hay Conductores registrados" : "OK",
            $conductor
        );
    }

    public function insertarvehiculos(array $data): array {
        // Definir variables de salida
        DB::statement("SET @idconductor = 0;");
        DB::statement("SET @success = 0;");
        DB::statement("SET @message = '';");

        // Llamar al SP con parámetros IN + OUT
        DB::statement("CALL sp_conductoresinsertar(?, ?, @idconductor, @success, @message)", [
            isset($data['nombre']) ? $data['nombre'] : null,
            isset($data['dni']) ? $data['dni'] : null
        ]);


        // Obtener resultados de las variables OUT
        $result = DB::select("SELECT @idconductor as idconductor, @success as success, @message as message");
        return GlobalModel::returnArray(
            $result[0]->success == 1,
            $result[0]->message,
            [
                [
                    "idconductor" => $result[0]->idconductor
                ]
            ]
        );
    }
}
