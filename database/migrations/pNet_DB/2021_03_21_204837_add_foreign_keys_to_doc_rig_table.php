<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDocRigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->table('doc_rig', function (Blueprint $table) {
            $table->foreign('id_doc_tes', 'doc_rig_ibfk_1')->references('id_doc_tes')->on('doc_tes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('id_art', 'doc_rig_ibfk_2')->references('id_art')->on('articoli')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->table('doc_rig', function (Blueprint $table) {
            $table->dropForeign('doc_rig_ibfk_1');
            $table->dropForeign('doc_rig_ibfk_2');
        });
    }
}
