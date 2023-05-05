<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePriceManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_price_manager', function (Blueprint $table) {
            $table->id();
            $table->string('id_cli_for', 8)->default('')->nullable();
            $table->tinyInteger('id_tipo_cl')->default(0)->nullable();
            $table->string('id_fam', 8)->default('');
            $table->integer('listino');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('w_price_manager');
    }
}
