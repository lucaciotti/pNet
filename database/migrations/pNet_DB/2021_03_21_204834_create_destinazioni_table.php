<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinazioniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinazioni', function (Blueprint $table) {
            $table->string('id_dest', 16)->default('');
            $table->tinyInteger('id_dest_pro')->default(0);
            $table->string('id_cli_for', 8)->default('')->index('id_cli_for');
            $table->string('indirizzo', 40)->default('');
            $table->string('citta', 40)->default('');
            $table->string('cap', 8)->default('');
            $table->string('provincia', 8)->default('');
            $table->string('telefono', 24)->default('');
            $table->string('fax', 24)->default('');
            $table->string('persona_rif1', 24)->default('');
            $table->string('persona_rif2', 24)->default('');
            $table->string('rag_soc', 32)->default('');
            $table->string('id_gru', 8)->default('');
            $table->string('rag_soc2', 40)->default('');
            $table->tinyInteger('std')->default(0);
            $table->primary(['id_dest', 'id_dest_pro', 'id_cli_for']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('destinazioni', function (Blueprint $table) {
















        });
    }
}
