<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iva', function (Blueprint $table) {
            $table->string('id_iva',2)->primary();
            $table->string('descr', 60)->default('');
            $table->decimal('perc', 4, 2)->default(0);
            $table->string('natura', 5)->default('');
            $table->string('normativa', 100)->default('');
            $table->string('natura2', 5)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iva');
    }
}
