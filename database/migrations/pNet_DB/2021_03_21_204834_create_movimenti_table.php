<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->create('movimenti', function (Blueprint $table) {
            $table->integer('id_mov')->default(0);
            $table->integer('id_tes')->default(0);
            $table->integer('id_art')->default(0);
            $table->decimal('qta', 16, 5)->default(0.00000);
            $table->decimal('prezzo', 16, 5)->default(0.00000);
            $table->decimal('iva', 8, 1)->default(0.0);
            $table->tinyInteger('tipo_off')->default(0);
            $table->tinyInteger('dist_base')->default(0);
            $table->tinyInteger('tra_centro')->default(0);
            $table->tinyInteger('omaggio')->default(0);
            $table->tinyInteger('etichetta')->default(0);
            $table->tinyInteger('elaborato')->default(0);
            $table->dateTime('data_reg');
            $table->decimal('sc1')->default(0.00);
            $table->decimal('sc2')->default(0.00);
            $table->decimal('sc3')->default(0.00);
            $table->decimal('sc4')->default(0.00);
            $table->decimal('prezzo_ml', 16, 5)->default(0.00000);
            $table->decimal('provv')->default(0.00);
            $table->integer('id_mov1')->default(0);
            $table->integer('id_mov2')->default(0);
            $table->date('data_scad');
            $table->string('tipo_om', 8)->default('');
            $table->tinyInteger('listino')->default(0);
            $table->decimal('p_acq', 16, 5)->default(0.00000);
            $table->integer('id_ven')->default(0);
            $table->string('id_c_f', 24)->default('');
            $table->decimal('pesol', 16, 3)->default(0.000);
            $table->integer('collil')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->drop('movimenti', function (Blueprint $table) {
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        });
    }
}
