<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableWDocRow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('w_doc_row', function (Blueprint $table) {
            $table->string('descr')->default('')->after('id_art');
            $table->decimal('prezzo', 16, 5)->default(0.00000)->after('quantity');
            $table->decimal('iva', 8, 1)->default(0.0)->after('prezzo');
            $table->decimal('val_riga', 16)->default(0.00)->after('iva');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('w_doc_row', function (Blueprint $table) {
            $table->dropColumn('descr');
            $table->dropColumn('prezzo');
            $table->dropColumn('iva');
            $table->dropColumn('val_riga');
        });
    }
}
