<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrdRigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parideNet')->table('ord_rig', function (Blueprint $table) {
            $table->foreign('id_ord_tes', 'ord_rig_ibfk_1')->references('id_ord_tes')->on('ord_tes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parideNet')->table('ord_rig', function (Blueprint $table) {
            $table->dropForeign('ord_rig_ibfk_1');
        });
    }
}
