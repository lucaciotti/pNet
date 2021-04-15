<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articoli', function (Blueprint $table) {
            $table->integer('id_art')->default(0)->primary();
            $table->string('descr', 48)->default('');
            $table->string('descr_pos', 24)->default('');
            $table->string('id_tipo', 8)->default('');
            $table->string('id_fam', 8)->default('');
            $table->string('id_sta', 8)->default('');
            $table->string('id_iva', 8)->default('');
            $table->decimal('prezzo_a_l', 16, 5)->default(0.00000);
            $table->decimal('sc1')->default(0.00);
            $table->decimal('sc2')->default(0.00);
            $table->decimal('sc3')->default(0.00);
            $table->decimal('sc4')->default(0.00);
            $table->decimal('prezzo_a', 16, 5)->default(0.00000);
            $table->decimal('ric_1')->default(0.00);
            $table->decimal('prezzo_1', 16, 5)->default(0.00000);
            $table->decimal('ric_2')->default(0.00);
            $table->decimal('prezzo_2', 16, 5)->default(0.00000);
            $table->decimal('ric_3')->default(0.00);
            $table->decimal('prezzo_3', 16, 5)->default(0.00000);
            $table->decimal('ric_4')->default(0.00);
            $table->decimal('prezzo_4', 16, 5)->default(0.00000);
            $table->string('um', 8)->default('');
            $table->integer('pz_x_conf')->default(0);
            $table->decimal('peso_vol', 8, 3)->default(0.000);
            $table->tinyInteger('id_etichet')->default(0);
            $table->string('id_cod_bar', 16)->default('');
            $table->string('id_cod_for', 24)->default('');
            $table->string('id_cli_for', 8)->default('')->index('id_cli_for');
            $table->tinyInteger('prz_bloc')->default(0);
            $table->tinyInteger('t_o')->default(0);
            $table->dateTime('data_reg')->nullable();
            $table->tinyInteger('non_attivo')->default(0);
            $table->string('id_cat', 8)->default('');
            $table->string('loc_art', 24)->default('');
            $table->tinyInteger('marg_fisso')->default(0);
            $table->string('stato_art', 8)->default('');
            $table->tinyInteger('kit')->default(0);
            $table->string('note2', 40)->default('');
            $table->decimal('provv_art')->default(0.00);
            $table->string('descr2', 48)->default('');
            $table->string('nome_foto', 56)->default('');
            $table->text('desc_ecom')->default('');
            $table->decimal('prz_ecom', 16, 5)->default(0.00000);
            $table->string('nome_foto2', 8)->default('');
            $table->string('nome_foto3', 8)->default('');
            $table->string('nome_foto4', 8)->default('');
            $table->string('nome_foto5', 8)->default('');
            $table->string('file_tecn', 8)->default('');
            $table->string('file_sicu', 8)->default('');
            $table->text('qr_code')->default('');
            $table->text('note3')->default('');
            $table->integer('uid')->default(0);
            $table->tinyInteger('aggiorna')->default(0);
            $table->text('titolo')->default('');
            $table->integer('collegato')->default(0);
            $table->integer('min_acq')->default(0);
            $table->decimal('peso', 8, 3)->default(0.000);
            $table->integer('lunghezza')->default(0);
            $table->integer('larghezza')->default(0);
            $table->integer('altezza')->default(0);
            $table->tinyInteger('spe_gratis')->default(0);
            $table->text('tag')->default('');
            $table->decimal('glassa')->default(0.00);
            $table->decimal('prezzo_5', 16, 6)->default(0.000000);
            $table->decimal('ric_5')->default(0.00);
            $table->decimal('prezzo_6', 16, 6)->default(0.000000);
            $table->decimal('ric_6')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articoli', function (Blueprint $table) {



































































        });
    }
}
