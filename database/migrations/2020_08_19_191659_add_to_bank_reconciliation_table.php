<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToBankReconciliationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_reconciliation', function (Blueprint $table) {
            //
            $table->string('difference',15);
            $table->string('cleared_balance',15);
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
            //
            $table->dropColumn('reconcile_date');
            $table->dropColumn('difference');
            $table->dropColumn('cleared_balance');
        });
    }
}
