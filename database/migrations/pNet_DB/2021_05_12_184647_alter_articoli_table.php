<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterArticoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articoli', function (Blueprint $table) {
            $table->string('descr', 250)->change();
            $table->string('descr_pos', 250)->change();
            $table->string('nome_foto', 250)->change();
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
            $table->string('descr', 48)->change();
            $table->string('descr_pos', 24)->change();
            $table->string('nome_foto', 56)->change();
        });
    }
}
