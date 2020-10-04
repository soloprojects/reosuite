<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->string('task')->nullable();
            $table->string('desc')->nullable();
            $table->string('priority')->nullable();
            $table->string('assigned_user')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('work_hours')->nullable();
            $table->string('task_status')->nullable();
            $table->integer('milestone_id')->nullable();
            $table->integer('task_list_id')->nullable();
            $table->longText('task_docs')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
