<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PpmTablePricedoctemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_price_doc_temp', function (Blueprint $table) {
            $table->id();
            $table->integer('id_doc_rig')->comment('Riga del documento')->index('id_doc_rig');
            $table->date('datarif')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Data Riferimento Listino');
            $table->string('id_cli_for', 8)->default('')->index('id_cli_for');
            $table->tinyInteger('id_tipo_cl')->default(0)->comment('Tipologia Cliente');
            $table->integer('id_art')->default(0)->index('id_art');
            $table->string('id_fam', 8)->comment('Riferimento Gruppo Prodotto');
            $table->integer('pz_x_conf')->default(0)->comment('PzConf su Articolo alla Data Rif');
            $table->decimal('qta', 16, 4)->default(0.0000)->comment('Qta in riga originaria');
            $table->tinyInteger('listino')->default(1)->comment('Listino di Riferimento');
            $table->decimal('prezzo', 16, 5)->default(0.00000)->comment('Prezzo calcolato');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('w_price_doc_temp');
    }
}
