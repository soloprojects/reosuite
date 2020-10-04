<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToAccountChart2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_chart', function (Blueprint $table) {
            //
            $table->string('virtual_balance',20)->nullable()->change();
            $table->string('virtual_balance_trans',20)->nullable()->change();
            $table->string('bank_balance',20)->nullable()->change();
            $table->string('original_cost',20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_chart', function (Blueprint $table) {
            //
            $table->dropColumn('virtual_balance');
            $table->dropColumn('virtual_balance_trans');
            $table->dropColumn('bank_balance');
            $table->dropColumn('origingal_cost');
        });
    }
}
