<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('customer_id');
            $table->integer('contract_type')->nullable();
            $table->integer('contract_status')->nullable();
            $table->string('recurring_cost',11)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('invoice_id',50)->nullable();
            $table->string('servicing_interval',20)->nullable();
            $table->string('total_amount',20)->nullable();
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
        Schema::dropIfExists('inventory_contract');
    }
}
