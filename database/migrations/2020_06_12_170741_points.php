<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Points extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) { //Log of points
            $table->uuid("id")->primary();
            $table->string("points_for")->index(); //Kis chiz ke lie point mile - like events attending, scavenger hunt, video seeing, etc
            $table->uuid("points_to")->index(); //Kisko mile - user-id
            $table->integer("points"); //Kitne points mile
            $table->string("details")->default(1)->index(); //id of item for which points are given
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
