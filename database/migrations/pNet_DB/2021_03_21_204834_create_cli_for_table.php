<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCliForTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_for', function (Blueprint $table) {
            $table->string('id_cli_for', 8)->default('')->primary();
            $table->string('id_cod_bar', 16)->default('');
            $table->string('rag_soc', 56)->default('');
            $table->string('rag_soc2', 56)->default('');
            $table->date('data_nasc')->nullable();
            $table->string('indirizzo', 56)->default('');
            $table->string('citta', 56)->default('');
            $table->string('cap', 8)->default('');
            $table->string('provincia', 8)->default('');
            $table->string('p_i', 24)->default('');
            $table->string('telefono', 24)->default('');
            $table->string('fax', 24)->default('');
            $table->integer('id_lis')->default(0);
            $table->decimal('sconto')->default(0.00);
            $table->string('nota_sconto', 24)->default('');
            $table->string('id_ban', 8)->default('');
            $table->string('id_pag', 8)->default('');
            $table->decimal('id_fido', 16)->default(0.00);
            $table->decimal('scoperto', 16)->default(0.00);
            $table->decimal('fatturato', 16)->default(0.00);
            $table->decimal('insoluti', 16)->default(0.00);
            $table->string('pers_rif1', 16)->default('');
            $table->string('pers_rif2', 16)->default('');
            $table->text('note')->nullable();
            $table->tinyInteger('id_tipo_cli')->default(0);
            $table->string('sesso', 8)->default('');
            $table->integer('bollini')->default(0);
            $table->integer('bollini_evasi')->default(0);
            $table->decimal('saldo_iniz', 16, 4)->default(0.0000);
            $table->date('dt_saldoi')->nullable();
            $table->decimal('dare', 16, 4)->default(0.0000);
            $table->decimal('avere', 16, 4)->default(0.0000);
            $table->decimal('provv_cli')->default(0.00);
            $table->string('id_zona', 8)->default('');
            $table->string('id_agente', 8)->default('');
            $table->string('id_rit', 8)->default('');
            $table->date('data_c')->nullable();
            $table->date('data_m')->nullable();
            $table->tinyInteger('spese_inc')->default(0);
            $table->decimal('fatt_prec', 16)->default(0.00);
            $table->tinyInteger('socio')->default(0);
            $table->decimal('sc1f')->default(0.00);
            $table->decimal('sc2f')->default(0.00);
            $table->decimal('sc3f')->default(0.00);
            $table->decimal('sc4f')->default(0.00);
            $table->tinyInteger('esenzione')->default(0);
            $table->string('id_iva_c', 8)->default('');
            $table->string('telefono1', 24)->default('');
            $table->string('cell', 24)->default('');
            $table->string('e_mail', 80)->default('');
            $table->string('www', 32)->default('');
            $table->string('tipo_co', 8)->default('');
            $table->tinyInteger('lingua')->default(0);
            $table->string('c_f', 16)->default('');
            $table->tinyInteger('bloccato')->default(0);
            $table->text('note2')->nullable();
            $table->date('data_fid')->nullable();
            $table->tinyInteger('tstudio')->default(0);
            $table->tinyInteger('profes')->default(0);
            $table->tinyInteger('figli')->default(0);
            $table->tinyInteger('statoc')->default(0);
            $table->tinyInteger('ncomp')->default(0);
            $table->date('datafi1')->nullable();
            $table->date('datafi2')->nullable();
            $table->date('datafi3')->nullable();
            $table->date('datafi4')->nullable();
            $table->date('datafi5')->nullable();
            $table->tinyInteger('frequenz')->default(0);
            $table->tinyInteger('h_giard')->default(0);
            $table->tinyInteger('h_faida')->default(0);
            $table->tinyInteger('h_lett')->default(0);
            $table->tinyInteger('h_mus')->default(0);
            $table->tinyInteger('h_anim')->default(0);
            $table->tinyInteger('h_decou')->default(0);
            $table->tinyInteger('h_armob')->default(0);
            $table->tinyInteger('h_artes')->default(0);
            $table->tinyInteger('h_casa')->default(0);
            $table->string('p_num1', 32)->default('');
            $table->string('p_num2', 32)->default('');
            $table->date('p_datai1')->nullable();
            $table->date('p_dataf1')->nullable();
            $table->date('p_datai2')->nullable();
            $table->date('p_dataf2')->nullable();
            $table->string('p_emesso1', 32)->default('');
            $table->string('p_emesso2', 32)->default('');
            $table->tinyInteger('p_tipodoc')->default(0);
            $table->string('iban', 40)->default('');
            $table->tinyInteger('id_caud')->default(0);
            $table->decimal('mod', 16)->default(0.00);
            $table->string('clioff', 8)->default('');
            $table->string('codufficio', 16)->default('');
            $table->string('codcliest', 16)->default('');
            $table->decimal('sconto1')->default(0.00);
            $table->decimal('soglia1', 16)->default(0.00);
            $table->string('nome', 32)->default('');
            $table->string('cognome', 32)->default('');
            $table->string('stato', 24)->default('');
            $table->tinyInteger('consenso1')->default(0);
            $table->tinyInteger('consenso2')->default(0);
            $table->tinyInteger('split')->default(0);
            $table->tinyInteger('nopvddt')->default(0);
            $table->text('note3')->nullable();
            $table->tinyInteger('fat_email')->default(0);
            $table->string('esigib', 8)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cli_for', function (Blueprint $table) {








































































































        });
    }
}
