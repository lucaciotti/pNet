<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreteColliTab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colli_tab', function (Blueprint $table) {
            $table->integer('id_doc_tes')->default(0);
            $table->integer('num')->default(0);
            $table->decimal('peso',10,3)->default(0.000);
            $table->decimal('lung',10,2)->default(0.00);
            $table->decimal('larg',10,2)->default(0.00);
            $table->decimal('alte',10,2)->default(0.00);
            
            $table->primary(['id_doc_tes', 'num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colli_tab');
    }
}
