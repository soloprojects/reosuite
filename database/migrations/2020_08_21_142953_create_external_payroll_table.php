<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_payroll', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('component')->nullable();
            $table->integer('user_id')->nullable()->index();
            $table->string('gross_pay','20')->nullable();
            $table->string('total_amount','20')->nullable();
            $table->string('tax_amount','20')->nullable();
            $table->integer('curr_id')->nullable();
            $table->integer('salary_id')->nullable()->index();
            $table->integer('dept_id')->nullable()->index();
            $table->integer('position_id')->nullable();
            $table->string('bonus_deduc',20)->nullable();
            $table->string('bonus_deduc_desc')->nullable();
            $table->integer('bonus_deduc_type')->nullable();
            $table->string('sal_adv_deduct',20)->nullable();
            $table->string('loan_deduct',20)->nullable();
            $table->integer('payroll_status')->nullable();
            $table->date('process_date')->nullable();
            $table->date('pay_date')->nullable();
            $table->string('week',50)->nullable();
            $table->string('month',22)->nullable();
            $table->integer('pay_year')->nullable();
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
        Schema::dropIfExists('external_payroll');
    }
}
