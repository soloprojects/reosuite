<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_category', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('salary_id');
            $table->string('comp_id');
            $table->string('amount');
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
        //Schema::table('salary_category', function (Blueprint $table) {
            //
            Schema::dropIfExists('salary_category');
        //});
    }
}
