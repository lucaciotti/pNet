<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIdDestType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('destinazioni', function (Blueprint $table) {
            $table->unsignedInteger('id_dest_pro')->default(0)->change();
        });
        Schema::table('doc_tes', function (Blueprint $table) {
            $table->unsignedInteger('id_dest')->default(0)->change();
        });
        Schema::table('ord_tes', function (Blueprint $table) {
            $table->unsignedInteger('id_dest')->default(0)->change();
        });
        Schema::table('w_doc_head', function (Blueprint $table) {
            $table->unsignedInteger('id_dest_pro')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('destinazioni', function (Blueprint $table) {
            $table->tinyInteger('id_dest_pro')->default(0)->change();
        });
        Schema::table('doc_tes', function (Blueprint $table) {
            $table->tinyInteger('id_dest')->default(0)->change();
        });
        Schema::table('ord_tes', function (Blueprint $table) {
            $table->tinyInteger('id_dest')->default(0)->change();
        });
        Schema::table('w_doc_head', function (Blueprint $table) {
            $table->tinyInteger('id_dest_pro')->default(0)->change();
        });
    }
}
