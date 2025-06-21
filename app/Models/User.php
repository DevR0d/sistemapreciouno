<?php

namespace App\Models;

use App\Models\Global\GlobalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'idrol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ----------- AUTENTICACIÓN PERSONALIZADA -------------
    public function login(array $parametros): array
    {
        global $message, $usuario;
        $usuario = $this->existeusuario($parametros["login"]);

        if ($usuario["data"] === null) {
            $message = "El Login no existe";
        } elseif (Hash::check($parametros["password"], $usuario["data"]->password)) {
            $message = "OK";
        } else {
            $message = "La Clave es Incorrecta";
        }

        return GlobalModel::returnArray(!empty($usuario), $message, $usuario["data"]);
    }

    public function existeusuario($login): array
    {
        $query = DB::table('v_usuario');
        $usuario = $query->where('email', $login)->get()->map(fn($item) => (array) $item)->toArray();

        return GlobalModel::returnArray(
            !empty($usuario),
            empty($usuario) ? "No Existe Usuario" : "Existe Usuario",
            $usuario
        );
    }

    // ----------- CRUD PERSONALIZADO -----------------------

    public function mostrarusuarios(array $parametros = []): array
    {
        $query = DB::table('users')->where('estado', '!=', 'Eliminado');

        if (isset($parametros['id'])) {
            $query->where('id', $parametros['id']);
        }
        if (isset($parametros['name'])) {
            $query->where('name', 'like', '%' . $parametros['name'] . '%');
        }
        if (isset($parametros['email'])) {
            $query->where('email', $parametros['email']);
        }
        if (isset($parametros['idrol'])) {
            $query->where('idrol', $parametros['idrol']);
        }

        if (isset($parametros['paginado']) && $parametros['paginado'] === true) {
            $porPagina = $parametros['porPagina'] ?? 10;
            $usuarios = $query->orderByDesc('id')->paginate($porPagina);

            return GlobalModel::returnArray(
                $usuarios->count() > 0,
                $usuarios->count() === 0 ? "No hay usuarios registrados" : "OK",
                $usuarios
            );
        }

        $usuarios = $query->get()->map(fn($item) => (array) $item)->toArray();
        return GlobalModel::returnArray(
            !empty($usuarios),
            empty($usuarios) ? "No hay usuarios registrados" : "OK",
            $usuarios
        );
    }

    public function insertarusuarios(array $data): array
    {
        DB::statement("SET @id = 0;");
        DB::statement("SET @success = 0;");
        DB::statement("SET @message = '';");

        //para hashear las contraseñas
        $password = isset($data['password']) ? Hash::make($data['password']) : null;

        DB::statement("CALL sp_usuarioinsertar(?, ?, ?, ?, @id, @success, @message)", [
            $data['name'] ?? null,
            $data['email'] ?? null,
            $password,
            $data['idrol'] ?? null,
        ]);

        $result = DB::select("SELECT @id as id, @success as success, @message as message");
        return GlobalModel::returnArray(
            $result[0]->success == 1,
            $result[0]->message,
            [['id' => $result[0]->id]]
        );
    }

    public function editarusuarios(array $datos): array
    {
        if (!isset($datos['id'])) {
            return GlobalModel::returnArray(false, 'id es obligatorio');
        }

        $id = $datos['id'];
        unset($datos['id']); // No queremos actualizar la PK

        if (empty($datos)) {
            return GlobalModel::returnArray(false, 'No hay datos para actualizar');
        }

        $usuario = self::find($id);
        if (!$usuario) {
            return GlobalModel::returnArray(false, 'Usuario no encontrado');
        }

        foreach ($datos as $key => $value) {
            if (Schema::hasColumn('users', $key) && !is_null($value)) {
                $usuario->$key = $key === 'password' ? Hash::make($value) : $value;
            }
        }

        $usuario->save();

        return GlobalModel::returnArray(
            true,
            'Usuario editado correctamente',
            $usuario
        );
    }
}
