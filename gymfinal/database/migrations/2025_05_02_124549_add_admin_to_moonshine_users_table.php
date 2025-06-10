<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insertar un nuevo administrador en la tabla moonshine_users
        DB::table('moonshine_users')->insert([
            'name' => '1',
            'email' => '1@gmail.com',
            'password' => bcrypt('1'), // Asegúrate de usar bcrypt para la contraseña
            'moonshine_user_role_id' => 1, // Asegúrate de que este ID corresponda al rol de administrador
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar el administrador añadido
        DB::table('moonshine_users')->where('email', 'admin@example.com')->delete();
    }
};
