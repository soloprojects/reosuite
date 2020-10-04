<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTempUserAnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_temp_user_ans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('test_id');
            $table->integer('cat_id');
            $table->integer('quest_id');
            $table->integer('session_id');
            $table->integer('text_type');
            $table->integer('user_id');
            $table->longText('text_answer')->nullable();
            $table->integer('correct_status');
            $table->integer('ans_id');
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('test_temp_user_ans');
    }
}
