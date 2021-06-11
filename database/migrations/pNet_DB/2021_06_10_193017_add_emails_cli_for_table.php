<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailsCliForTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cli_for', function (Blueprint $table) {
            $table->string('e_mail_amministrazione', 80)->default('');
            $table->string('e_mail_ordini', 80)->default('');
            $table->string('e_mail_ddt', 80)->default('');
            $table->string('e_mail_fatture', 80)->default('');
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
            $table->dropColumn(['e_mail_amministrazione', 'e_mail_ordini', 'e_mail_ddt', 'e_mail_fatture']);
        });
    }
}
