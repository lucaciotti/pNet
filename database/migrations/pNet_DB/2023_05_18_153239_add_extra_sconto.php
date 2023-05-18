<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraSconto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('w_price_manager', function (Blueprint $table) {
            $table->float('extrasconto')->default(0.00)->after('listino');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('w_price_manager', function (Blueprint $table) {
            $table->dropColumn('extrasconto');
        });
    }
}
