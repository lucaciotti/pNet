<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('codag', 3)->nullable()->comment('Codice Agente Associato');
            $table->string('codcli', 6)->nullable()->comment('Codice Cliente Associato');
            $table->string('codfor', 6)->nullable()->comment('Codice Fornitore Associato');
            $table->string('ditta', 2)->default('')->comment('Ditta visibile all\'utente');
            $table->string('nickname')->unique('nickname_email_unique')->after('name')->comment('NickName Unique for Login');
            $table->string('avatar')->default('avatar_default.jpg')->comment('Profile\'s Image');
            $table->string('lang', 2)->default('')->comment('Language per User: it, en, es');
            $table->boolean('isActive')->nullable()->default(false)->comment('User is Active?');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['codag', 'codcli', 'codfor', 'ditta', 'avatar', 'lang', 'isActive']);
            $table->dropUnique('nickname_email_unique');
        });
    }
}
