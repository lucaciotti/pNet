<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagazzinoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magazzino', function (Blueprint $table) {
            $table->integer('id_mag');
            $table->integer('id_art')->index('id_art');
            $table->double('scorta_min')->nullable();
            $table->double('lotto_rio')->nullable();
            $table->double('qta_ini')->nullable();
            $table->double('qta_acq')->nullable();
            $table->double('qta_ven')->nullable();
            $table->double('qta_fine')->nullable();
            $table->double('esistenza')->nullable();
            $table->double('esi_fine_a')->nullable();
            $table->primary(['id_mag', 'id_art']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('magazzino', function (Blueprint $table) {











        });
    }
}
