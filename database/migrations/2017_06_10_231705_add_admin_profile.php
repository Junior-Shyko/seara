<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
            // Adiciona os valores padrão dos perfis
            DB::table('profiles')->insert(array(
              array('profile_name' => 'Administrador da Empresa'), // 3
            ));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
            Schema::dropIfExists('profiles');
        });
    }
}
