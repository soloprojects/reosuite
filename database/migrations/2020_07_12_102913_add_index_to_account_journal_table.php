<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToAccountJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_journal', function (Blueprint $table) {
            //
            $table->index('uid');
            $table->index('extension_id');
            $table->index('acct_cat_id');
            $table->index('detail_id');
            $table->index('account_id');
            $table->index('chart_id');
            $table->index('item_id');
            $table->index('fin_year');
            $table->index('class_id');
            $table->index('location_id');
            $table->index('vendor_customer');
            $table->index('debit_credit');
            $table->index('transaction_type');
            $table->index('reconcile_status');
            $table->index('post_date');
            $table->index('status');
            $table->index('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_journal', function (Blueprint $table) {
            //
        });
    }
}
