<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Booths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booths', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("room_id");
            $table->string("name")->nullable();
            $table->string("type")->nullable();
            $table->longText("description")->nullable(); //Wysiwyg
            $table->text("url")->nullable();
            $table->string("boothurl")->nullable();
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
        //
    }
}
