<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleMaintenanceReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_maintenance_reminder', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('service_types')->nullable();
            $table->string('mileage')->nullable();
            $table->string('interval')->nullable();
            $table->date('last_reminder')->nullable();
            $table->date('next_reminder')->nullable();
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
        Schema::dropIfExists('vehicle_maintenance_reminder');
    }
}
