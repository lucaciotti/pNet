<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CorrectPrivacyUserAgree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('privacyTerms_user_agree', function (Blueprint $table) {
            $table->renameColumn('marketing_aggrement', 'marketing_agreement');
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
            $table->renameColumn('marketing_agreement', 'marketing_aggrement');
        });
    }
}
