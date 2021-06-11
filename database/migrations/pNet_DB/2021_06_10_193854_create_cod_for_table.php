<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodForTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_for', function (Blueprint $table) {
            $table->integer('id_art')->unsigned();
            $table->string('id_cod_for', 20)->default('----');
            $table->string('id_cli_for', 8);
            $table->decimal('pz_x_car', 4, 0)->default(0);
            $table->decimal('prezzo_a_l', 13, 5)->default(0);
            $table->decimal('sc1', 6, 2)->default(0);
            $table->decimal('sc2', 6, 2)->default(0);
            $table->decimal('sc3', 6, 2)->default(0);
            $table->decimal('sc4', 6, 2)->default(0);
            $table->decimal('prezzo_a', 13, 5)->default(0);
            $table->decimal('ric', 6, 2)->default(0);
            $table->decimal('prezzo_c', 13, 5)->default(0);
            $table->decimal('prz_a_l2', 13, 5)->default(0);
            $table->decimal('prz_a2', 13, 5)->default(0);
            $table->primary(['id_art', 'id_cod_for', 'id_cli_for']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_for');
    }
}
