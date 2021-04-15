<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ord_tes', function (Blueprint $table) {
            $table->integer('id_ord_tes')->default(0)->primary();
            $table->string('num', 16)->default('');
            $table->string('rif_num', 16)->default('');
            $table->date('data')->nullable();
            $table->date('data_eva')->nullable();
            $table->string('id_cli_for', 8)->default('')->index('id_cli_for');
            $table->tinyInteger('id_dest')->default(0);
            $table->string('id_cf_dest', 8)->default('');
            $table->tinyInteger('esente_iva')->default(0);
            $table->string('id_pag', 8)->default('');
            $table->string('id_ban', 8)->default('');
            $table->text('note')->default('');
            $table->string('stato', 8)->default('');
            $table->tinyInteger('stampato')->default(0);
            $table->text('note2')->default('');
            $table->string('id_tra', 8)->default('');
            $table->tinyInteger('id_por')->default(0);
            $table->tinyInteger('id_cor')->default(0);
            $table->string('tipo', 8)->default('');
            $table->decimal('tot_imp', 16, 3)->default(0.000);
            $table->decimal('tot_iva', 16, 3)->default(0.000);
            $table->string('nome1', 40)->default('');
            $table->string('nome2', 40)->default('');
            $table->string('nome3', 40)->default('');
            $table->string('nome4', 40)->default('');
            $table->tinyInteger('listino')->default(0);
            $table->tinyInteger('ord_elaborato')->default(0);
            $table->tinyInteger('id_mag')->default(0);
            $table->tinyInteger('scorp_iva')->default(0);
            $table->decimal('sconto')->default(0.00);
            $table->tinyInteger('arrotond')->default(0);
            $table->string('id_age', 8)->default('');
            $table->tinyInteger('lingua')->default(0);
            $table->string('id_iva_c', 8)->default('');
            $table->integer('colli')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ord_tes', function (Blueprint $table) {



































        });
    }
}
