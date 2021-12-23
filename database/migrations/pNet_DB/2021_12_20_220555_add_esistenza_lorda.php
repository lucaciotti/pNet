<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEsistenzaLorda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magazzino', function (Blueprint $table) {
            $table->double('esistenza_lorda')->after('esistenza')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('magazzino', function (Blueprint $table) {
            $table->dropColumn(['esistenza_lorda']);
        });
    }
}
