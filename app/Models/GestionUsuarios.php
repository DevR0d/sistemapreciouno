<?php

namespace App\Models;

// use App\Models\Global\GlobalModel;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

// class GestionUsuarios extends Model
// {
//     protected $table = 'users'; 
//     protected $primaryKey = 'id'; 
//     public $timestamps = false; 


//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//         'idrol',
//     ];


//     public function mostrarusuarios(array $parametros = []): array
//     {
//         $query = DB::table('users');

      
//         if (isset($parametros['id'])) {
//             $query->where('id', $parametros['id']);
//         }

//         if (isset($parametros['name'])) {
//             $query->where('name', 'like', '%' . $parametros['name'] . '%');
//         }

//         if (isset($parametros['email'])) {
//             $query->where('email', $parametros['email']);
//         }

//         if (isset($parametros['idrol'])) {
//             $query->where('idrol', $parametros['idrol']);
//         }

//         if (isset($parametros['paginado']) && $parametros['paginado'] === true) {
//             $porPagina = $parametros['porPagina'] ?? 10;
//             $usuarios = $query->orderByDesc('id')->paginate($porPagina);

//             return GlobalModel::returnArray(
//                 $usuarios->count() > 0,
//                 $usuarios->count() === 0 ? "No hay usuarios registrados" : "OK",
//                 $usuarios 
//             );
//         }

        
//         $usuarios = $query->get()->map(fn($item) => (array) $item)->toArray();
//         return GlobalModel::returnArray(
//             !empty($usuarios),
//             empty($usuarios) ? "No hay usuarios registrados" : "OK",
//             $usuarios
//         );
//     }

    
//     public function insertarusuarios(array $data): array
//     {
       
//         DB::statement("SET @id = 0;");
//         DB::statement("SET @success = 0;");
//         DB::statement("SET @message = '';");

        
//         DB::statement("CALL sp_usuarioinsertar(?, ?, ?, ?, @id, @success, @message)", [
//             isset($data['name']) ? $data['name'] : null,
//             isset($data['email']) ? $data['email'] : null,
//             isset($data['password']) ? $data['password'] : null,
//             isset($data['idrol']) ? $data['idrol'] : null,
//         ]);

     
//         $result = DB::select("SELECT @id as id, @success as success, @message as message");
//         return GlobalModel::returnArray(
//             $result[0]->success == 1,
//             $result[0]->message,
//             [
//                 [
//                     "id" => $result[0]->id
//                 ]
//             ]
//         );
//     }

    
//     public function editarusuarios(array $datos): array
//     {
//         if (!isset($datos['id'])) {
//             return GlobalModel::returnArray(false, 'id es obligatorio');
// }

//         $id = $datos['id'];
//         unset($datos['id']); 

        
//         DB::statement("SET @success = 0;");
//         DB::statement("SET @message = '';");

       
//         DB::statement("CALL sp_usuarioeditar(?, ?, ?, ?, @success, @message)", [
//             $id,
//             isset($datos['name']) ? $datos['name'] : null,
//             isset($datos['email']) ? $datos['email'] : null,
//             isset($datos['password']) ? $datos['password'] : null,
//         ]);

        
//         $result = DB::select("SELECT @success as success, @message as message");
//         return GlobalModel::returnArray(
//             $result[0]->success == 1,
//             $result[0]->message
//         );
//     }
// }
