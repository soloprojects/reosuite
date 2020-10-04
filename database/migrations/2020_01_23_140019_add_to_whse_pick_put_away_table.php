<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToWhsePickPutAwayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whse_pick_put_away', function (Blueprint $table) {
            //
            $table->integer('sales_id')->nullable();
            $table->integer('sales_ext_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whse_pick_put_away', function (Blueprint $table) {
            //
            $table->dropColumn('sales_id');
            $table->dropColumn('sales_ext_id');
        });
    }
}
