<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalDefaultTransactionAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_default_transaction_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('default_account_payable')->nullable();
            $table->integer('default_account_receivable')->nullable();
            $table->integer('default_sales_tax_account')->nullable();
            $table->integer('default_discount_account')->nullable();
            $table->integer('default_payroll_tax_account')->nullable();
            $table->integer('default_sales_return_account')->nullable();
            $table->integer('default_purchase_tax')->nullable();
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
        Schema::dropIfExists('journal_default_transaction_account');
    }
}
