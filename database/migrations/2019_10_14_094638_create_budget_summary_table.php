<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_summary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fin_year_id')->nullable();
            $table->string('name',100)->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('approval_display')->nullable();
            $table->string('budget_amount',20)->nullable();
            $table->integer('approved_by')->nullable();
            $table->integer('approval_status')->nullable();
            $table->date('approval_date')->nullable();
            $table->text('reviewer_comment')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('budget_summary');
    }
}
