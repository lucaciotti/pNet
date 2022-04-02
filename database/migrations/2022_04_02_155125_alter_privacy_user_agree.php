<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPrivacyUserAgree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('privacyTerms_user_agree', function (Blueprint $table) {
            $table->string('name', 50)->default('')->change();
            $table->string('surname', 50)->default('')->change();
            $table->boolean('privacy_agreement')->default(0)->change();
            $table->boolean('marketing_aggrement')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('privacyTerms_user_agree', function (Blueprint $table) {
            $table->string('name', 50)->change();
            $table->string('surname', 50)->change();
            $table->boolean('privacy_agreement')->change();
            $table->boolean('marketing_aggrement')->change();
        });
    }
}
