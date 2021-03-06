<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToAccountJournalTable2 extends Migration
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
            $table->string('excl_tax_discount',15)->nullable();
            $table->string('excl_tax_discount_trans',15)->nullable();
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
            $table->dropColumn('excl_tax_discount');
            $table->dropColumn('excl_tax_discount_trans');
        });
    }
}
