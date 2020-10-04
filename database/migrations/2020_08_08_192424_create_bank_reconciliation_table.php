<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankReconciliationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_reconciliation', function (Blueprint $table) {

            $table->string('register_balance','20')->nullable();
            $table->string('bank_balance','20')->nullable();
            $table->integer('count_cleared_payments')->nullable();
            $table->integer('count_cleared_deposits')->nullable();
            $table->integer('count_uncleared_payments')->nullable();
            $table->integer('count_uncleared_deposits')->nullable();
            $table->date('reconcile_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_reconciliation', function (Blueprint $table) {

            $table->dropColumn('register_balance','20');
            $table->dropColumn('bank_balance','20');
            $table->dropColumn('count_cleared_payments');
            $table->dropColumn('count_cleared_deposits');
            $table->dropColumn('count_uncleared_payments');
            $table->dropColumn('count_uncleared_deposits');
            $table->dropColumn('reconcile_date');
        });
    }
}
