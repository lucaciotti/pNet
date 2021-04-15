<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_tes', function (Blueprint $table) {
            $table->integer('id_doc_tes')->default(0)->primary();
            $table->tinyInteger('tipo_doc')->default(0);
            $table->integer('id_tes ??')->default(0);
            $table->date('data')->nullable();
            $table->string('num', 16)->default('');
            $table->string('id_cli_for', 8)->default('')->index('id_cli_for');
            $table->tinyInteger('id_mag_des')->default(0);
            $table->tinyInteger('id_mag')->default(0);
            $table->tinyInteger('id_dest')->default(0);
            $table->tinyInteger('listino')->default(0);
            $table->tinyInteger('esenzione_iva')->default(0);
            $table->string('id_age', 8)->default('');
            $table->string('id_zona', 8)->default('');
            $table->string('id_pag', 8)->default('');
            $table->string('id_ban', 8)->default('');
            $table->string('id_spe', 8)->default('');
            $table->decimal('sconto')->default(0.00);
            $table->string('id_porto', 8)->default('');
            $table->tinyInteger('id_asp')->default(0);
            $table->integer('colli')->default(0);
            $table->dateTime('data_ora_par')->nullable();
            $table->tinyInteger('id_cau_doc')->default(0);
            $table->tinyInteger('stampato')->default(0);
            $table->decimal('tot_imp', 16)->default(0.00);
            $table->decimal('tot_iva', 16)->default(0.00);
            $table->dateTime('data_reg')->nullable();
            $table->tinyInteger('fatturato')->default(0);
            $table->tinyInteger('scorp_iva')->default(0);
            $table->tinyInteger('id_vet')->default(0);
            $table->tinyInteger('no_mov')->default(0);
            $table->string('doc_note', 200)->default('');
            $table->decimal('doc_acconto', 16, 4)->default(0.0000);
            $table->tinyInteger('rb')->default(0);
            $table->tinyInteger('scadenze')->default(0);
            $table->tinyInteger('ritenuta')->default(0);
            $table->decimal('tot_rit', 16)->default(0.00);
            $table->decimal('spese_ban', 16)->default(0.00);
            $table->date('data_div')->nullable();
            $table->decimal('peso', 16, 3)->default(0.000);
            $table->decimal('tot_daris', 16)->default(0.00);
            $table->tinyInteger('arrotond')->default(0);
            $table->string('id_iva_c', 8)->default('');
            $table->tinyInteger('modscad')->default(0);
            $table->string('descr_aeb', 32)->default('');
            $table->string('des_dive1', 40)->default('');
            $table->string('des_dive2', 40)->default('');
            $table->string('des_dive3', 40)->default('');
            $table->string('des_dive4', 40)->default('');
            $table->string('id_acc', 8)->default('');
            $table->tinyInteger('pagato')->default(0);
            $table->decimal('scontop')->default(0.00);
            $table->integer('numd')->default(0);
            $table->tinyInteger('split')->default(0);
            $table->tinyInteger('leggisco')->default(0);
            $table->text('ddt_rif')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doc_tes', function (Blueprint $table) {























































        });
    }
}
