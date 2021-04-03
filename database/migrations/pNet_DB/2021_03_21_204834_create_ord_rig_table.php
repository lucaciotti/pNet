<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdRigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->create('ord_rig', function (Blueprint $table) {
            $table->integer('id_ord_tes')->default(0)->index('id_ord_tes');
            $table->integer('id_ord_rig')->default(0)->primary();
            $table->integer('id_art')->default(0);
            $table->date('data_eva');
            $table->string('descr', 48)->default('');
            $table->string('id_iva', 8)->default('');
            $table->decimal('qta_ord', 16, 3)->default(0.000);
            $table->decimal('qta_eva', 16, 3)->default(0.000);
            $table->decimal('prezzo', 16, 5)->default(0.00000);
            $table->decimal('sc1')->default(0.00);
            $table->decimal('sc2')->default(0.00);
            $table->decimal('sc3')->default(0.00);
            $table->decimal('sc4')->default(0.00);
            $table->tinyInteger('omaggio')->default(0);
            $table->string('um', 8)->default('');
            $table->string('id_cod_for', 24)->default('');
            $table->decimal('iva', 8, 1)->default(0.0);
            $table->decimal('val_riga', 16)->default(0.00);
            $table->decimal('prezzo_lis', 16, 5)->default(0.00000);
            $table->string('id_cod_b', 16)->default('');
            $table->integer('cartoni')->default(0);
            $table->text('libero')->default('');
            $table->decimal('prz_a2v', 16, 5)->default(0.00000);
            $table->tinyInteger('omaggiot')->default(0);
            $table->string('descr2', 48)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->drop('ord_rig', function (Blueprint $table) {
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        });
    }
}
