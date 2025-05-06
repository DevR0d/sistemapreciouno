<?php

namespace App\Models;

use App\Models\Global\GlobalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Guiasderemision extends Model
{
    protected $table = 'guias_remision'; // Especifica el horaemision exacto de la tabla
    protected $primaryKey = 'idguia'; // Si tu clave primaria no se llama "id"
    public $timestamps = false; // Desactiva timestamps si tu tabla no tiene created_at / updated_at

    // Opcional: si quieres proteger o permitir ciertas columnas
    protected $fillable = [
        'tim',
        'fechaemision',
        'horaemision',
        'motivotraslado',
        'origen',
        'destino',
        'estado',
        'cantidadenviada',
        'idvehiculo',
        'idconductor',
    ];

    // Relación con Vehiculo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'idvehiculo');
    }

    // Relación con Conductor
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'idconductor');
    }

    public function mostrarguiasderemision(array $parametros = []): array {
        $query = DB::table('v_guias_remision');

        // Filtros condicionales
        if (isset($parametros['idguia'])) {
            $query->where('idguia', $parametros['idguia']);
        }

        if (isset($parametros['tim'])) {
            $query->where('tim', $parametros['tim']);
        }

        if (isset($parametros['fechaemision'])) {
            $query->where('fechaemision', $parametros['fechaemision']);
        }

        if (isset($parametros['horaemision'])) {
            $query->where('horaemision', $parametros['horaemision']);
        }

        if (isset($parametros['motivotraslado'])) {
            $query->where('motivotraslado', $parametros['motivotraslado']);
        }

        if (isset($parametros['origen'])) {
            $query->where('origen', $parametros['origen']);
        }

        if (isset($parametros['destino'])) {
            $query->where('destino', $parametros['destino']);
        }

        if (isset($parametros['estado'])) {
            $query->where('estado', $parametros['estado']);
        }

        if (isset($parametros['cantidadenviada'])) {
            $query->where('cantidadenviada', $parametros['cantidadenviada']);
        }

        if (isset($parametros['idvehiculo'])) {
            $query->where('idvehiculo', $parametros['idvehiculo']);
        }

        if (isset($parametros['idconductor'])) {
            $query->where('idconductor', $parametros['idconductor']);
        }

        // Verificar si se pide paginación
        if (isset($parametros['paginado']) && $parametros['paginado'] === true) {
            $porPagina = $parametros['porPagina'] ?? 10;
            $guiasderemision = $query->orderByDesc('idguia')->paginate($porPagina);

            return GlobalModel::returnArray(
                $guiasderemision->count() > 0,
                $guiasderemision->count() === 0 ? "No hay guias de remision registradas" : "OK",
                $guiasderemision // Retorna el paginador
            );
        }

        // Si no hay paginado, obtener todo
        $guiasderemision = $query->get()->map(fn($item) => (array) $item)->toArray();
        return GlobalModel::returnArray(
            !empty($guiasderemision),
            empty($guiasderemision) ? "No hay guias de remision registradas" : "OK",
            $guiasderemision
        );
    }

    public function insertarGuiasRemision(array $data): array {
        // Definir variables de salida
        DB::statement("SET @idguia = 0;");
        DB::statement("SET @success = 0;");
        DB::statement("SET @message = '';");

        // Llamar al SP con parámetros IN + OUT
        DB::statement("CALL sp_guiasremision(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @idguia, @success, @message)", [
            isset($data['tim']) ? $data['tim'] : null,
            isset($data['fechaemision']) ? $data['fechaemision'] : null,
            isset($data['horaemision']) ? $data['horaemision'] : null,
            isset($data['motivotraslado']) ? $data['motivotraslado'] : null,
            isset($data['origen']) ? $data['origen'] : null,
            isset($data['destino']) ? $data['destino'] : null,
            isset($data['estado']) ? $data['estado'] : null,
            isset($data['cantidadenviada']) ? $data['cantidadenviada'] : null,
            isset($data['idvehiculo']) ? $data['idvehiculo'] : null,
            isset($data['idconductor']) ? $data['idconductor'] : null
        ]);


        // Obtener resultados de las variables OUT
        $result = DB::select("SELECT @idguia as idguia, @success as success, @message as message");
        return GlobalModel::returnArray(
            $result[0]->success == 1,
            $result[0]->message,
            [
                [
                    "idguia" => $result[0]->idguia
                ]
            ]
        );
    }
}
