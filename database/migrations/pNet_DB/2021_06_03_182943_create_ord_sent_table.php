<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdSentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_ord_sent', function (Blueprint $table) {
            $table->id();
            $table->integer('id_doc')->unique();
            $table->string('tipo_doc', 2)->default('');
            $table->string('id_cli', 8)->default('');
            $table->boolean('inviato')->default(false);
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
        Schema::dropIfExists('w_ord_sent');
    }
}
