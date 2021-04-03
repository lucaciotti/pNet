<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMagazzinoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->table('magazzino', function (Blueprint $table) {
            $table->foreign('id_art', 'magazzino_ibfk_1')->references('id_art')->on('articoli')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->table('magazzino', function (Blueprint $table) {
            $table->dropForeign('magazzino_ibfk_1');
        });
    }
}
