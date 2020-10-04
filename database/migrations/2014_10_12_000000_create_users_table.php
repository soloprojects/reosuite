<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->string('local_mail');
            $table->string('role');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othername');
            $table->string('sex');
            $table->string('dob');
            $table->string('phone');
            $table->string('job_role');
            $table->string('address');
            $table->string('employ_type');
            $table->string('position_id');
            $table->string('dept_id');
            $table->string('salary_id');
            $table->string('nationality');
            $table->string('marital');
            $table->string('blood_group');
            $table->string('next_kin');
            $table->string('next_kin_phone');
            $table->string('state');
            $table->string('local_govt');
            $table->string('guarantor');
            $table->string('guarantor_phone');
            $table->string('photo');
            $table->string('title');
            $table->string('qualification');
            $table->string('employ_date');
            $table->string('resign_date');
            $table->string('activity');
            $table->string('status');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
