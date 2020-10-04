<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('title');
            $table->string('desc');
            $table->string('qualification');
            $table->string('experience');
            $table->string('status');
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
        //Schema::table('position', function (Blueprint $table) {
            //
            Schema::dropIfExists('position');

        //});
    }
}
