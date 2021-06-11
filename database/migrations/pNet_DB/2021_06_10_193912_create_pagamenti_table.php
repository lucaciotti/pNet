<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagamentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamenti', function (Blueprint $table) {
            $table->integer('id_pag')->primary();
            $table->string('descr', 40)->default('');
            $table->boolean('spese_ban')->default(false);
            $table->boolean('spese_boll')->default(false);
            $table->integer('num_rate')->default(0);
            $table->integer('gg_x_rata')->default(0);
            $table->boolean('par_f_m')->default(false);
            $table->boolean('rb')->default(false);
            $table->integer('ggpr')->default(0);
            $table->boolean('par_meta')->default(false);
            $table->boolean('f_a')->default(false);
            $table->integer('sposta')->default(0);
            $table->decimal('scontop', 8, 2)->default(0);
            $table->string('id_pag_pa', 4)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagamenti');
    }
}
