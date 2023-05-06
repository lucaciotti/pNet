<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableWDocHead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('w_doc_head', function (Blueprint $table) {
            $table->string('rif_num', 16)->default('')->after('tipo_doc');
            $table->date('data')->nullable()->after('rif_num');
            $table->date('data_eva')->nullable()->after('data');
            $table->string('id_pag', 8)->default('')->after('id_cli_for');
            $table->string('tipo_sped')->default('')->after('id_pag');
            $table->text('note')->nullable()->after('tipo_sped');
            $table->decimal('tot_imp', 16, 3)->default(0.000)->after('note');
            $table->decimal('tot_iva', 16, 3)->default(0.000)->after('tot_imp');
            $table->decimal('totale', 16, 3)->default(0.000)->after('tot_iva');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('w_doc_head', function (Blueprint $table) {
            $table->dropColumn('rif_num');
            $table->dropColumn('data');
            $table->dropColumn('data_eva');
            $table->dropColumn('id_pag');
            $table->dropColumn('tipo_sped');
            $table->dropColumn('note');
            $table->dropColumn('tot_imp');
            $table->dropColumn('tot_iva');
            $table->dropColumn('totale');
        });
    }
}
