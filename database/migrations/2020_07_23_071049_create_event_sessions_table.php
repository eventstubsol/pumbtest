<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_sessions', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name")->nullable();
            $table->string("room")->default(EVENT_ROOM_AUDI);
            $table->string("type")->default(ZOOM_SESSION);
            $table->longText("description")->nullable();
            $table->dateTime("start_time")->nullable();
            $table->dateTime("end_time")->nullable();
            $table->mediumText("vimeo_url")->nullable();
            $table->string("zoom_webinar_id")->nullable();
            $table->string("zoom_password")->nullable();
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
        Schema::dropIfExists('event_sessions');
    }
}
