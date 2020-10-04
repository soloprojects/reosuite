<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToJournalExtention extends Migration
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
            $table->renameColumn('vendor_cutomer','vendor_customer');
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
            $table->renameColumn('vendor_cutomer','vendor_customer');
        });
    }
}
