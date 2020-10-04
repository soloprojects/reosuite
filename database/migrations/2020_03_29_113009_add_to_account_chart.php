<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToAccountChart extends Migration
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
            $table->integer('virtual_balance')->nullable();
            $table->integer('virtual_balance_trans')->nullable();
            $table->integer('bank_balance')->nullable();
            $table->integer('original_cost')->nullable();
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
