<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHseReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('report_type');
            $table->integer('source_id')->nullable();
            $table->text('report_details')->nullable();
            $table->string('location')->nullable();
            $table->integer('response_status')->nullable();
            $table->text('response')->nullable();
            $table->date('report_date')->nullable();
            $table->integer('report_status')->nullable();
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
        Schema::dropIfExists('hse_reports');
    }
}
