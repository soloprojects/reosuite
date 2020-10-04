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
        Schema::create('bank_reconciliation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->date('ending_date');
            $table->string('begining_balance',20);
            $table->string('ending_balance',20);
            $table->string('deposits_cleared',20);
            $table->string('payments_cleared',20);
            $table->string('uncleared_deposits',20);
            $table->string('uncleared_payments',20);
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
        Schema::dropIfExists('bank_reconciliation');
    }
}
