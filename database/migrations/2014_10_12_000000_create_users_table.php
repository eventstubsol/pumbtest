<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('SET SESSION sql_require_primary_key=0');
        Schema::create('users', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('name')->index();
            $table->string("last_name")->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('job_title')->nullable();
            $table->string('company_name')->nullable();
            $table->string('country')->nullable();
            $table->string('industry')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean("isCometChatAccountExist")->default(FALSE);
            $table->string('password')->nullable();
            $table->string('type')->default("attendee");    //Admin, Exhibitor, Attendee, SuperAdmin - if needed
            $table->integer('points')->default(0);
            $table->mediumText("profileImage")->nullable();
            $table->mediumText("bio")->nullable();
            $table->tinyInteger("online_status")->default(0);
            $table->string("current_page")->index()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
