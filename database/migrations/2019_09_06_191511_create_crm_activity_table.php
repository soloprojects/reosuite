<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_activity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->nullable();
            $table->integer('opportunity_id')->nullable();
            $table->integer('activity_type')->nullable();
            $table->string('subject')->nullable();
            $table->text('details')->nullable();
            $table->integer('due_date')->nullable();
            $table->text('response')->nullable();
            $table->integer('response_status')->nullable();
            $table->integer('response_rate')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('crm_activity');
    }
}
