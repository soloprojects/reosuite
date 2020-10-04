<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToJournalDefaultAccountTransaction extends Migration
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
            $table->renameColumn('default_sales_discount','default_discount_allowed');
            $table->renameColumn('default_purchase_discount','default_discount_received');
            $table->renameColumn('default_sales_return','default_inventory');
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
            $table->renameColumn('default_sales_discount','default_discount_allowed');
            $table->renameColumn('default_purchase_discount','default_discount_received');
            $table->renameColumn('default_sales_return','default_inventory');
        });
    }
}
