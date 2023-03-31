<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVettori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vettori', function (Blueprint $table) {            
            $table->tinyInteger('id_vet')->default(0)->primary();
            $table->string('rag_soc1', 40)->default('');
            $table->string('rag_soc2', 40)->default('');
            $table->string('pivav', 16)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vettori');
    }
}
