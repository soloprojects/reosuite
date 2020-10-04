<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('vehicle_id');
            $table->integer('contract_type')->nullable();
            $table->integer('contract_status')->nullable();
            $table->string('recurring_cost',11)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('recurring_interval',20)->nullable();
            $table->string('mileage_start',5)->nullable();
            $table->string('mileage_end',5)->nullable();
            $table->string('activation_cost',20)->nullable();
            $table->string('contractor',100)->nullable();
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
        Schema::dropIfExists('vehicle_contract');
    }
}
