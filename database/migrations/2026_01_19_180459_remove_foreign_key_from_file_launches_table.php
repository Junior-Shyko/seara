<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveForeignKeyFromFileLaunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_launches', function (Blueprint $table) {
            $table->dropForeign(['file_launches_id_entry']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_launches', function (Blueprint $table) {
            $table->foreign('file_launches_id_entry')->references('entries_id')->on('entries');
        });
    }
}
