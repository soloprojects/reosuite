<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToInventoryContractTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_contract', function (Blueprint $table) {
            //
            $table->integer('active_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_contract', function (Blueprint $table) {
            //
            $table->dropColumn('active_status');
        });
    }

}
