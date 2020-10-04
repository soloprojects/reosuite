<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid',20);
            $table->integer('make_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('location')->nullable();
            $table->string('chasis_no')->nullable();
            $table->string('model_year',10)->nullable();
            $table->date('registration_date')->nullable();
            $table->date('registration_due_date')->nullable();
            $table->string('purchase_price',20)->nullable();
            $table->string('seat_number',5)->nullable();
            $table->string('doors',5)->nullable();
            $table->string('colour',20)->nullable();
            $table->string('transmission',20)->nullable();
            $table->string('fuel_type',30)->nullable();
            $table->string('horsepower',10)->nullable();
            $table->string('mileage',20)->nullable();
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
        Schema::dropIfExists('vehicle');
    }
}
