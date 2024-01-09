<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterListMatrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listmatrice', function (Blueprint $table) {
            $table->integer('id_tipo_cl')->nullable()->default(null)->change();
            $table->date('da_data')->default(Carbon::now())->change();
            $table->date('a_data')->default(Carbon::now()->subDays(1))->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listmatrice', function (Blueprint $table) {
            $table->integer('id_tipo_cl')->nullable()->change();
            $table->date('da_data')->change();
            $table->date('a_data')->change();
        });
    }
}
