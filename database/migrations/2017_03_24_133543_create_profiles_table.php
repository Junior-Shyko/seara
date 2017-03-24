<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('profiles', function (Blueprint $table) {
        $table->increments('profile_id'); // id do perfil
        $table->string('profile_name');   // nome do tipo de perfil
        $table->timestamps();
      });

      // Adiciona os valores padrão dos perfis
      DB::table('profiles')->insert(array(
        array('profile_name' => 'Super'),               // 1
        array('profile_name' => 'Administrador Geral'), // 2
        array('profile_name' => 'Funcionário'),         // 3
        array('profile_name' => 'Funcionário Seara')    // 4
      ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
