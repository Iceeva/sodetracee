<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddAdminUserToUsersTable extends Migration
{
    public function up()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@sodeco.com',
            'password' => Hash::make('admin123'), // Mot de passe haché
            'role' => 'admin', // Champ personnalisé pour le rôle
            'email_verified_at' => now(), // Email déjà vérifié
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        DB::table('users')->where('email', 'admin@sodeco.com')->delete();
    }
}
