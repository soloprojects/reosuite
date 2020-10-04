<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleServiceLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_service_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vehicle_id');
            $table->integer('service_type')->nullable();
            $table->string('mileage_in',11)->nullable();
            $table->integer('driver_id')->nullable();
            $table->string('mileage_out',11)->nullable();
            $table->date('service_date')->nullable();
            $table->string('invoice_reference',30)->nullable();
            $table->string('total_price',11)->nullable();
            $table->string('location')->nullable();
            $table->string('comment')->nullable();
            $table->string('workshop',10)->nullable();
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
        Schema::dropIfExists('vehicle_service_log');
    }
}
