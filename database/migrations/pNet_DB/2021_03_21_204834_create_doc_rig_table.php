<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocRigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_rig', function (Blueprint $table) {
            $table->integer('id_doc_rig')->default(0)->primary();
            $table->integer('id_doc_tes')->default(0)->index('id_doc_tes');
            $table->integer('id_mov')->default(0);
            $table->integer('id_art')->default(0)->index('id_art');
            $table->string('descr', 48)->default('');
            $table->decimal('qta', 16, 4)->default(0.0000);
            $table->decimal('prezzo', 16, 5)->default(0.00000);
            $table->decimal('sc1')->default(0.00);
            $table->decimal('sc2')->default(0.00);
            $table->decimal('iva', 8, 1)->default(0.0);
            $table->string('um', 8)->default('');
            $table->tinyInteger('tipo_off')->default(0);
            $table->tinyInteger('dist_base')->default(0);
            $table->tinyInteger('omaggio')->default(0);
            $table->tinyInteger('elaborato')->default(0);
            $table->dateTime('data_reg')->nullable();
            $table->decimal('val_riga', 16)->default(0.00);
            $table->string('id_iva', 8)->default('');
            $table->text('libero')->nullable();
            $table->tinyInteger('listino')->default(0);
            $table->tinyInteger('omaggiot')->default(0);
            $table->string('descr2', 48)->default('');
            $table->string('lottof', 16)->default('');
            $table->string('rifamm', 24)->default('');
            $table->decimal('tot_ivar', 16)->default(0.00);
            $table->string('ddt_num', 16)->default('');
            $table->date('ddt_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doc_rig', function (Blueprint $table) {



























        });
    }
}
