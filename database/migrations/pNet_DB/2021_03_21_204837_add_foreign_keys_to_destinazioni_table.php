<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDestinazioniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->table('destinazioni', function (Blueprint $table) {
            $table->foreign('id_cli_for', 'destinazioni_ibfk_1')->references('id_cli_for')->on('cli_for')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->table('destinazioni', function (Blueprint $table) {
            $table->dropForeign('destinazioni_ibfk_1');
        });
    }
}
