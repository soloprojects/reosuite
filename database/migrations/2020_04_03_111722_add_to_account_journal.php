<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToAccountJournal extends Migration
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
            
            $table->dropColumn('qty_to_assemble_order');
            $table->dropColumn('reserved_qty');
            $table->dropColumn('qty_to_ship');
            $table->dropColumn('planned_receipt_date');
            $table->dropColumn('expected_receipt_date');
            $table->dropColumn('promised_receipt_date');
            $table->dropColumn('balance');
            $table->dropColumn('open_balance_status');
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
            $table->string('reserved_quantity',20)->nullable();
            $table->string('qty_to_ship',20)->nullable();
            $table->string('qty_to_assemble_order')->nullable();
            $table->date('planned_receipt_date')->nullable();
            $table->date('expected_receipt_date')->nullable();
            $table->date('promised_receipt_date')->nullable();
            $table->string('balance',15)->nullable();
            $table->string('open_balance_status',15)->nullable();
        });
    }
}
