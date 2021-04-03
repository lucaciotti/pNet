<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamigliaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->create('famiglia', function (Blueprint $table) {
            $table->string('id_fam', 8)->default('')->primary();
            $table->string('descr', 64)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->drop('famiglia', function (Blueprint $table) {
            
            
        });
    }
}
