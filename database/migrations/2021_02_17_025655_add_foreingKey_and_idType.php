<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingKeyAndIdType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_launches', function (Blueprint $table) {
            $table->string('account_launches_referring', 50);
            $table->char('account_launches_status', 2);
            $table->integer('account_launches_id_type')->unsigned()->nullable();
            $table->foreign('account_launches_id_type')->references('id')->on('account_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_launches', function (Blueprint $table) {
            $table->dropColumn('account_launches_referring', 50);
            $table->dropColumn('account_launches_status', 2);
            $table->dropForeign(['account_launches_id_type']);
        });
    }
}
