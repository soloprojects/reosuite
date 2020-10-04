<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsLearntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_learnt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->date('lesson_date')->nullable();
            $table->string('subject')->nullable();
            $table->string('situation')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('importance')->nullable();
            $table->string('need')->nullable();
            $table->string('follow_up')->nullable();
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
        Schema::dropIfExists('lessons_learnt');
    }
}
