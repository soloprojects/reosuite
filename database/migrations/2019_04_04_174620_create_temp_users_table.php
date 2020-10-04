<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('othername')->nullable();
            $table->string('sex')->nullable();
            $table->string('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('discipline')->nullable();
            $table->string('experience')->nullable();
            $table->string('address')->nullable();
            $table->string('rate_type')->nullable();
            $table->string('rate')->nullable();
            $table->string('cv')->nullable();
            $table->integer('dept_id');
            $table->string('nationality')->nullable();
            $table->string('photo')->nullable();
            $table->string('qualification')->nullable();
            $table->string('cert')->nullable();
            $table->string('cert_expiry_date')->nullable();
            $table->string('cert_issue_date')->nullable();
            $table->string('bupa_hmo_expiry_date')->nullable();
            $table->string('green_card_expiry_date')->nullable();
            $table->string('activity')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('temp_users');
    }
}
