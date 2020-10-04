<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryComponentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_component', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('salary_id');
            $table->string('comp_name');
            $table->string('comp_desc');
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
        //Schema::table('salary_component', function (Blueprint $table) {
            //
            Schema::dropIfExists('salary_component');
        //});
    }
}
