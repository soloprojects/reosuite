<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleFuelLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_fuel_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vehicle_id');
            $table->string('liter',10)->nullable();
            $table->string('price_per_liter',11)->nullable();
            $table->integer('driver_id')->nullable();
            $table->string('mileage')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('invoice_reference',30)->nullable();
            $table->integer('fuel_station')->nullable();
            $table->string('comment')->nullable();
            $table->string('total_price',10)->nullable();
            $table->text('docs')->nullable();
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('vehicle_fuel_log');
    }
}
