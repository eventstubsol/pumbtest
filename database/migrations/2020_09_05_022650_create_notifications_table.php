<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("user_id")->index();
            $table->mediumText("details")->nullable();
            $table->string("type")->default("info");
            $table->string("action_type")->index();
            $table->string("action_id")->index();
            $table->string("action_status")->nullable();
            $table->longText("meta")->nullable();
            $table->tinyInteger("sent")->default(0);
            $table->tinyInteger("read")->default(0);
            $table->tinyInteger("clicked")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
