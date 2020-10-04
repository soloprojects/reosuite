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
            $table->integer('active_status');
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
            $table->dropColumn('active_status');
        });
    }
}
