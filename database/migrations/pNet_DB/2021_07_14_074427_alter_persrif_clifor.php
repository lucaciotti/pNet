<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPersrifClifor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cli_for', function (Blueprint $table) {
            $table->string('pers_rif1', 56)->default('')->change();
            $table->string('pers_rif2', 56)->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cli_for', function (Blueprint $table) {
            $table->string('pers_rif1', 16)->default('')->change();
            $table->string('pers_rif1', 16)->default('')->change();
        });
    }
}
