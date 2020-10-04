<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminApprovalSysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_approval_sys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('approval_name')->nullable();
            $table->longText('level_users')->nullable();
            $table->longText('level')->nullable();
            $table->longText('users')->nullable();
            $table->longText('json_display')->nullable();
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
        Schema::dropIfExists('admin_approval_sys');
    }
}
