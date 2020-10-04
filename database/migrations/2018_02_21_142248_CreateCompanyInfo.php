<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_info', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('email');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('logo');
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('status');
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
        //
        Schema::dropIfExists('company_info');

    }
}
