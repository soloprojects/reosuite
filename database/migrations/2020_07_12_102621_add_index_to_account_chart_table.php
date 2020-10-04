<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToAccountChartTable extends Migration
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
            $table->index('acct_cat_id');
            $table->index('detail_id');
            $table->index('curr_id');
            $table->index('status');
            $table->index('active_status');
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
        });
    }
}
