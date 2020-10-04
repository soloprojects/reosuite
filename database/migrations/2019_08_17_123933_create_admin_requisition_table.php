<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_requisition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('req_cat');
            $table->integer('req_type');
            $table->integer('project_id')->nullable();
            $table->integer('dept_id');
            $table->string('req_desc')->nullable();
            $table->string('edit_request')->nullable();
            $table->longText('approval_json')->nullable();
            $table->longText('approval_level')->nullable();
            $table->longText('approval_user')->nullable();
            $table->longText('approved_users')->nullable();
            $table->dateTime('approval_date')->nullable();
            $table->integer('approval_id');
            $table->integer('approval_status')->nullable();
            $table->integer('request_user');
            $table->integer('dept_req_user');
            $table->integer('deny_user');
            $table->integer('complete_status');
            $table->longText('attachment')->nullable();
            $table->longText('views')->nullable();
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
        Schema::dropIfExists('admin_requisition');
    }
}
