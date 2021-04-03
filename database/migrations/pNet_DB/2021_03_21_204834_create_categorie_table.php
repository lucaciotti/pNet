<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->create('categorie', function (Blueprint $table) {
            $table->string('id_cat', 8)->default('')->primary();
            $table->string('descr', 30)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->drop('categorie', function (Blueprint $table) {
            
            
        });
    }
}
