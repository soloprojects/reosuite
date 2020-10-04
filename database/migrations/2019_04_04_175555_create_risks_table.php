<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('risk_desc')->nullable();
            $table->string('probability')->nullable();
            $table->string('impact')->nullable();
            $table->string('detectability')->nullable();
            $table->string('importance')->nullable();
            $table->string('category')->nullable();
            $table->string('trigger')->nullable();
            $table->string('response')->nullable();
            $table->string('contingency_plan')->nullable();
            $table->string('risk_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('risks');
    }
}
