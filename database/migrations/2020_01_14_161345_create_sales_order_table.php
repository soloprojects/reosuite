<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uid');
            $table->integer('sales_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->text('sales_desc')->nullable();
            $table->string('unit_measurement',70)->nullable();
            $table->string('bin_stock')->nullable();
            $table->string('quantity',20)->nullable();
            $table->string('reserved_quantity',20)->nullable();
            $table->string('shipped_quantity',20)->nullable();
            $table->date('due_date')->nullable();
            $table->date('planned_ship_date')->nullable();
            $table->date('expected_ship_date')->nullable();
            $table->date('promised_ship_date')->nullable();
            $table->string('unit_cost',20)->nullable();
            $table->string('unit_cost_trans',20)->nullable();
            $table->string('discount_amount_trans',20)->nullable();
            $table->string('extended_amount_trans',20)->nullable();
            $table->string('tax_amount_trans',20)->nullable();
            $table->string('extended_amount',20)->nullable();
            $table->string('discount_perct',11)->nullable();
            $table->string('discount_amount',20)->nullable();
            $table->string('discount_type',11)->nullable();
            $table->string('tax_perct',10)->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('tax')->nullable();
            $table->integer('tax_id')->nullable();
            $table->date('post_date')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('requisition_id')->nullable();
            $table->integer('sales_status')->nullable();
            $table->text('sales_status_comment')->nullable();
            $table->text('status_comment_history')->nullable();
            $table->text('blanket_order_no')->nullable();
            $table->text('blanket_order_line_no')->nullable();
            $table->text('ship_to_whse')->nullable();
            $table->text('ship_status')->nullable();
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
        Schema::dropIfExists('sales_order');
    }
}
