<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFieldsTableEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('entries_balance_initial');
            $table->dropColumn('entries_balance_previous');
            $table->dropColumn('entries_decimate');
            $table->dropColumn('entries_offer');
            $table->dropColumn('entries_end');
            $table->dropColumn('entries_balance');
            $table->dropColumn('entries_balance_end');
            $table->dropColumn('entries_other');
            $table->float('entries_value', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->float('entries_balance_initial', 8,2);
            $table->float('entries_balance_previous', 8,2);
            $table->float('entries_decimate', 8,2);
            $table->float('entries_offer', 8,2);
            $table->float('entries_end', 8,2);
            $table->float('entries_balance', 8,2);
            $table->float('entries_balance_end', 8,2);
            $table->float('entries_other', 8,2);
        });
    }
}
