<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreteWDocHead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_doc_head', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_doc', 2)->default('');
            $table->string('id_cli_for', 8)->default('');
            $table->tinyInteger('id_dest_pro')->default(0);
            $table->boolean('processed')->default(0);
            $table->integer('id_ord_tes')->default(0);
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
        Schema::dropIfExists('w_doc_head');
    }
}
