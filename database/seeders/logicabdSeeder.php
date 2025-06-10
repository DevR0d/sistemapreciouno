<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class logicabdSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //esto es un array donde se llama a los archivos SQL.
        $archivosSQL = [
            "usuariospordefecto.sql",
            "productos.sql",
            "sp_preciouno.sql",
            "v_preciouno.sql"
        ];

        foreach ($archivosSQL as $archivo) {
            $ruta = database_path('sql/' . $archivo);

            // Verifica que el archivo exista
            if (File::exists($ruta)) {
                $sql = File::get($ruta);
                DB::unprepared($sql);
            }
        }
    }
}
