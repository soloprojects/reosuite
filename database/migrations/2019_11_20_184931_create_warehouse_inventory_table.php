<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('warehouse_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->integer('bin_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('status');
            $table->integer('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_inventory');
    }
}
