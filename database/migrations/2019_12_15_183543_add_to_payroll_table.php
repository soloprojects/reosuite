<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll', function (Blueprint $table) {
            //
            $table->string('sal_adv_deduct',20)->nullable();
            $table->string('loan_deduct',20)->nullable();
            $table->integer('pay_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll', function (Blueprint $table) {
            //
            $table->dropColumn('sal_adv_deduct');
            $table->dropColumn('loan_deduct');
            $table->dropColumn('pay_year');
        });
    }
}
