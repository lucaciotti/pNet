<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFotoArticoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articoli', function (Blueprint $table) {
            $table->string('nome_foto2', 250)->change();
            $table->string('nome_foto3', 250)->change();
            $table->string('nome_foto4', 250)->change();
            $table->string('nome_foto5', 250)->change();
            $table->string('file_tecn', 250)->change();
            $table->string('file_sicu', 250)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articoli', function (Blueprint $table) {
            //
        });
    }
}
