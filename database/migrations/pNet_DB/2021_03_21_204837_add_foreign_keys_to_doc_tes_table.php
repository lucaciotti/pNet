<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDocTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_tes', function (Blueprint $table) {
            $table->foreign('id_cli_for', 'doc_tes_ibfk_1')->references('id_cli_for')->on('cli_for')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_tes', function (Blueprint $table) {
            $table->dropForeign('doc_tes_ibfk_1');
        });
    }
}
