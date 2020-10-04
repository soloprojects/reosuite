<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToJournalExtention4 extends Migration
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
            $table->string('balance',11)->nullable();
            $table->string('balance_trans',11)->nullable();
            $table->string('balance_paid',11)->nullable();
            $table->string('balance_paid_trans',11)->nullable();
            $table->integer('balance_status')->nullable();
            $table->integer('journal_status')->nullable();
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
            $table->dropColumn('balance');
            $table->dropColumn('balance_trans');
            $table->dropColumn('balance_paid');
            $table->dropColumn('balance_paid_trans');
            $table->dropColumn('balance_status');
            $table->dropColumn('journal_status');
        });
    }
}
