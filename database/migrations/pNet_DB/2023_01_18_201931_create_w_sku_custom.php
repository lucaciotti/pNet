<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWSkuCustom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_sku_custom', function (Blueprint $table) {
            $table->integer('id_art');
            $table->string('id_cli_for', 8);
            $table->string('sku_code', 50);
            $table->timestamps();
            $table->primary(['id_art', 'id_cli_for']);
            $table->unique(['id_art', 'id_cli_for', 'sku_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('w_sku_custom');
    }
}
