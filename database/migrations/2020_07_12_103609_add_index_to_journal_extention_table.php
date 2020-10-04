<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToJournalExtentionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_extention', function (Blueprint $table) {
            //
            $table->index('uid');
            $table->index('journal_id');
            $table->index('file_no');
            $table->index('journal_status');
            $table->index('balance_status');
            $table->index('due_date');
            $table->index('class_id');
            $table->index('location_id');
            $table->index('vendor_customer');
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
        Schema::table('journal_extention', function (Blueprint $table) {
            //
        });
    }
}
