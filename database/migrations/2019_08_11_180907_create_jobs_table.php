<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title')->nullable();
            $table->string('job_type')->nullable();
            $table->string('location')->nullable();
            $table->string('salary_range')->nullable();
            $table->longText('job_purpose')->nullable();
            $table->longText('job_desc')->nullable();
            $table->integer('experience')->nullable();
            $table->longText('job_spec')->nullable();
            $table->integer('job_status');
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
        Schema::dropIfExists('jobs');
    }
}
