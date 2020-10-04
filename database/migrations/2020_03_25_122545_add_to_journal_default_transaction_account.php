<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToJournalDefaultTransactionAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_default_transaction_account', function (Blueprint $table) {
            //
            $table->renameColumn('default_discount_account','default_sales_discount');
            $table->renameColumn('default_sales_tax_account','default_sales_tax');
            $table->renameColumn('default_payroll_tax_account','default_payroll_tax');
            $table->renameColumn('default_sales_return_account','default_sales_return');
            $table->integer('default_purchase_discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_default_transaction_account', function (Blueprint $table) {
            //
            $table->renameColumn('default_discount_account','default_sales_discount');
            $table->renameColumn('default_sales_tax_account','default_sales_tax');
            $table->renameColumn('default_payroll_tax_account','default_payroll_tax');
            $table->renameColumn('default_sales_return_account','default_sales_return');
            $table->dropColumn('default_purchase_discount');
        });
    }
}
