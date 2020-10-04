<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('budget_id');
            $table->integer('fin_year_id');
            $table->integer('request_cat_id')->nullable();
            $table->integer('acct_id')->nullable();
            $table->integer('acct_cat_id')->nullable();
            $table->integer('acct_detail_id')->nullable();
            $table->integer('dept_id')->nullable();
            $table->string('jan',20)->nullable();
            $table->string('feb',20)->nullable();
            $table->string('march',20)->nullable();
            $table->string('first_quarter',20)->nullable();
            $table->string('april',20)->nullable();
            $table->string('may',20)->nullable();
            $table->string('june',20)->nullable();
            $table->string('second_quarter',20)->nullable();
            $table->string('july',20)->nullable();
            $table->string('august',20)->nullable();
            $table->string('sept',20)->nullable();
            $table->string('third_quarter',20)->nullable();
            $table->string('oct',20)->nullable();
            $table->string('nov',20)->nullable();
            $table->string('dec',20)->nullable();
            $table->string('fourth_quarter',20)->nullable();
            $table->string('total_cat_amount',20)->nullable();
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('budget');
    }
}
