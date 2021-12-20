<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PpmTableListini extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_listini', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('id_tipo_cl')->default(0)->comment('Gestione Tipologia Cliente');
            $table->string('id_cli_for', 8)->default('')->comment('Gestione Codice Cliente');
            $table->string('id_fam', 8)->comment('Riferimento Gruppo Prodotto');
            $table->date('datainizio')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Data Inizio Validità');
            $table->date('datafine')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Data Fine Validità');
            $table->tinyInteger('listino')->default(1)->comment('Listino di Riferimento');
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
        Schema::dropIfExists('w_listini');
    }
}
