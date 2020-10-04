<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToJournalExtention5 extends Migration
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
            $table->integer('class_id')->nullable();
            $table->integer('transaction_type')->nullable();
            $table->integer('transaction_format')->nullable();
            $table->integer('print_status')->nullable();
            $table->integer('file_no')->nullable();
            $table->integer('terms')->nullable();
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
            $table->dropColumn('class_id');
            $table->dropColumn('transaction_type');
            $table->dropColumn('transaction_format');
            $table->dropColumn('print_status');
            $table->dropColumn('file_no');
            $table->dropColumn('terms'); 
        });
    }
}
