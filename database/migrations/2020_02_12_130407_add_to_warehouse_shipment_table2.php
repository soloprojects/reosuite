<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToWarehouseShipmentTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_shipment', function (Blueprint $table) {
            //

            $table->integer('sales_id')->nullable();
            $table->integer('sales_ext_id')->nullable();
            $table->integer('sorting_method')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouse_shipment', function (Blueprint $table) {
            //
            $table->dropColumn('sales_id');
            $table->dropColumn('sales_ext_id');
            $table->dropColumn('sorting_method');
        });
    }
}
