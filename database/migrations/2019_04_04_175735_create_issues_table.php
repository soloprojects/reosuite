<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('issue_desc')->nullable();
            $table->string('impact')->nullable();
            $table->string('resolution')->nullable();
            $table->string('importance')->nullable();
            $table->string('issue_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('issues');
    }
}
