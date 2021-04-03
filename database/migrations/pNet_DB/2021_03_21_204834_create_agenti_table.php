<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->create('agenti', function (Blueprint $table) {
            $table->string('id_agente', 8)->default('')->primary();
            $table->string('nome', 32)->default('');
            $table->string('indirizzo', 32)->default('');
            $table->string('citta', 32)->default('');
            $table->string('cap', 8)->default('');
            $table->string('provincia', 8)->default('');
            $table->string('p_i', 24)->default('');
            $table->string('telefono', 24)->default('');
            $table->string('fax', 24)->default('');
            $table->text('note')->default('');
            $table->string('tipo', 8)->default('');
            $table->integer('id_zona')->default(0);
            $table->integer('tipo_matur')->default(0);
            $table->decimal('provv')->default(0.00);
            $table->string('id_ban', 8)->default('');
            $table->string('id_pag', 8)->default('');
            $table->string('emaila', 64)->default('');
            $table->string('acell', 32)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->drop('agenti', function (Blueprint $table) {
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        });
    }
}
