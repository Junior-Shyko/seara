<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');          // id
            $table->string('user_name');            // nome
            $table->string('user_email')->unique(); // email
            $table->string('user_phone');           // telefone
            $table->string('user_password');        // senha
            $table->string('user_cargo');           // senha
            $table->integer('user_id_company')
                  ->unsigned();
            $table->integer('user_id_profile')
                  ->unsigned();
            $table->date('user_birth');             // data de nascimento
            $table->string('user_sex');             // sexo
            $table->string('user_cpf')->unique();   // CPF (campo único)
            $table->string('user_street');          // Nome da rua
            $table->string('user_number');          // Número da casa
            $table->string('user_complement');      // Complemento
            $table->string('user_district');        // Bairro
            $table->string('user_city');            // Cidade
            $table->string('user_state');          // Estado
            $table->string('user_cep');             // CEP
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
