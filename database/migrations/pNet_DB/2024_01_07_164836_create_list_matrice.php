<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListMatrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listmatrice', function (Blueprint $table) {
            $table->boolean('attivo')->nullable()->default(false);
            $table->tinyInteger('id_tipo_cl')->nullable();
            $table->string('id_cli_for', 8)->default('');
            $table->string('id_fam', 8)->default('');
            $table->string('id_mar')->nullable();
            $table->integer('id_art')->default(0);
            $table->integer('id_lis')->default(0);
            $table->decimal('sconto')->default(0.00);
            $table->integer('idlis')->default(0);
            $table->date('da_data');
            $table->date('a_data');
            // $table->primary(['id_tipo_cl', 'id_cli_for', 'id_fam', 'id_art']);
            $table->primary(['idlis']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listmatrice');
    }
}
