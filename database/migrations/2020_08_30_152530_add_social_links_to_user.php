<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialLinksToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("facebook_link")->nullable();
            $table->string("twitter_link")->nullable();
            $table->string("linkedin_link")->nullable();
            $table->string("website_link")->nullable();
            $table->string("company_website_link")->nullable();
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
            $table->dropColumn("facebook_link");
            $table->dropColumn("twitter_link");
            $table->dropColumn("linkedin_link");
            $table->dropColumn("website_link");
            $table->dropColumn("company_website_link");
        });
    }
}
