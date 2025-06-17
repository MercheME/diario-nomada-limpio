<?php

namespace App\Console\Commands;

use App\Models\Comentario;
use App\Models\Destino;
use App\Models\DestinoImagen;
use App\Models\Diario;
use App\Models\DiarioImagen;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportDataToSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-data-to-seeder-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
     public function handle()
    {
          $this->info('Iniciando exportación de datos a un Seeder...');

        $seederContent = "<?php\n\nnamespace Database\Seeders;\n\nuse Illuminate\Database\Seeder;\nuse Illuminate\Support\Facades\DB;\nuse Illuminate\Support\Facades\Hash;\n";
        // Añadimos todas las sentencias 'use' para los modelos
        $seederContent .= "use App\Models\User;\n";
        $seederContent .= "use App\Models\Destino;\n";
        $seederContent .= "use App\Models\Diario;\n";
        $seederContent .= "use App\Models\Comentario;\n";
        $seederContent .= "use App\Models\Friendship;\n";
        $seederContent .= "use App\Models\DiarioImagen;\n";
        $seederContent .= "use App\Models\DestinoImagen;\n\n";
        // ... añade aquí los 'use' para Proyecto y ProyectoImagen si los usas

        $seederContent .= "class GeneratedDataSeeder extends Seeder\n{\n    public function run(): void\n    {\n";
        // $seederContent .= "        DB::statement('SET FOREIGN_KEY_CHECKS=0;');\n\n";
        $seederContent .= "        DB::statement(\"SET session_replication_role = 'replica';\");\n\n";


        // --- 1. Usuarios (no dependen de nadie) ---
        $this->line('Exportando Usuarios...');
        foreach (User::all() as $item) {
            $seederContent .= "        User::create([\n";
            $seederContent .= "            'id' => " . $item->id . ",\n";
            $seederContent .= "            'uuid' => '" . ($item->uuid ?? \Illuminate\Support\Str::uuid()) . "',\n";
            $seederContent .= "            'name' => '" . addslashes($item->name) . "',\n";
            $seederContent .= "            'email' => '" . $item->email . "',\n";
            $seederContent .= "            'password' => '" . $item->password . "',\n";
            $seederContent .= "            'bio' => '" . addslashes($item->bio ?? '') . "',\n";
            $seederContent .= "            'profile_image' => " . ($item->profile_image ? "'" . addslashes($item->profile_image) . "'" : "null") . ",\n";
            $seederContent .= "        ]);\n";
        }

        // --- 2. Destinos (no dependen de nadie) ---
        $this->line('Exportando Destinos...');
        foreach (Destino::all() as $item) {
            $seederContent .= "        Destino::create(['id' => " . $item->id . ", 'nombre_destino' => '" . addslashes($item->nombre_destino) . "', /*... otros campos ...*/ ]);\n";
        }

        // --- 3. Diarios (dependen de User) ---
        $this->line('Exportando Diarios...');
        foreach (Diario::all() as $item) {
            $seederContent .= "        Diario::create([ \n";
            $seederContent .= "           'id' => ". $item->id .",\n";
            $seederContent .= "           'user_id' => ". $item->user_id .",\n";
            $seederContent .= "           'titulo' => '". addslashes($item->titulo) ."',\n";
            $seederContent .= "           'contenido' => '". addslashes($item->contenido) ."',\n";
            // ...Añade el resto de tus campos de la tabla 'diarios' aquí...
            $seederContent .= "        ]);\n";
        }

        // --- 4. Imágenes de Diario (dependen de Diario) ---
        $this->line('Exportando DiarioImagenes...');
        foreach (DiarioImagen::all() as $item) {
            $seederContent .= "        DiarioImagen::create(['id' => ".$item->id.", 'diario_id' => ".$item->diario_id.", 'url_imagen' => '".addslashes($item->url_imagen)."', /*... otros campos ...*/]);\n";
        }

        // --- 5. Imágenes de Destino (dependen de Destino) ---
        $this->line('Exportando DestinoImagenes...');
        foreach (DestinoImagen::all() as $item) {
            $seederContent .= "        DestinoImagen::create(['id' => ".$item->id.", 'destino_id' => ".$item->destino_id.", 'url_imagen' => '".addslashes($item->url_imagen)."', /*... otros campos ...*/]);\n";
        }

        // --- 6. Comentarios (dependen de User y Diario) ---
        $this->line('Exportando Comentarios...');
        foreach (Comentario::all() as $item) {
            $seederContent .= "        Comentario::create(['id' => " . $item->id . ", 'user_id' => " . $item->user_id . ", 'diario_id' => " . $item->diario_id . ", 'contenido' => '" . addslashes($item->contenido) . "', /*... otros campos ...*/]);\n";
        }

        // --- 7. Amistades (dependen de User) ---
        $this->line('Exportando Friendships...');
        foreach (Friendship::all() as $item) {
            $seederContent .= "        Friendship::create([\n";
            $seederContent .= "            'user_id' => " . $item->user_id . ",\n";
            $seederContent .= "            'friend_id' => " . $item->friend_id . ",\n";
            $seederContent .= "            'status' => '" . $item->status . "',\n";
            $seederContent .= "        ]);\n";
        }

        // --- 8. Favoritos (tabla pivote, depende de User y Diario) ---
        $this->line('Exportando Favoritos (pivote)...');
        foreach (DB::table('favoritos_diarios')->get() as $row) {
            $seederContent .= "        DB::table('favoritos_diarios')->insert(['user_id' => " . $row->user_id . ", 'diario_id' => " . $row->diario_id . "]);\n";
        }

        // --- Añade aquí tus otras tablas como 'proyectos', 'proyecto_imagenes', 'favoritos_proyectos' si las necesitas ---

        // $seederContent .= "\n        DB::statement('SET FOREIGN_KEY_CHECKS=1;');\n";
        $seederContent .= "\n        DB::statement(\"SET session_replication_role = 'origin';\");\n";
        $seederContent .= "    }\n}\n";

        $filePath = database_path('seeders/GeneratedDataSeeder.php');
        File::put($filePath, $seederContent);

        $this->info('¡Exportación completada! Se ha creado el archivo: ' . $filePath);

        return 0;
    }
}
