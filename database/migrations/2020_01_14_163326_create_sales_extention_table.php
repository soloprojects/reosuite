<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesExtentionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_extention', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uid');
            $table->integer('assigned_user')->nullable();
            $table->string('sales_number',50)->nullable();
            $table->string('sum_total',20)->nullable();
            $table->string('trans_total',20)->nullable();
            $table->string('discount_total',20)->nullable();
            $table->string('discount_trans',20)->nullable();
            $table->string('tax_total',20)->nullable();
            $table->string('tax_trans',20)->nullable();
            $table->string('tax_type',20)->nullable();
            $table->string('tax_perct',20)->nullable();
            $table->string('discount_perct',20)->nullable();
            $table->integer('discount_type')->nullable();
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->integer('ex_rate')->nullable();
            $table->date('curr_date')->nullable();
            $table->integer('default_curr')->nullable();
            $table->integer('trans_curr')->nullable();
            $table->integer('customer')->nullable();
            $table->integer('contact_type')->nullable();
            $table->integer('employee_id')->nullable();
            $table->date('order_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('post_date')->nullable();
            $table->string('ship_to_city',70)->nullable();
            $table->string('ship_address',70)->nullable();
            $table->string('ship_to_country',70)->nullable();
            $table->string('ship_to_contact',70)->nullable();
            $table->string('ship_method',70)->nullable();
            $table->string('ship_agent')->nullable();
            $table->string('sales_status',50)->nullable();
            $table->string('mails')->nullable();
            $table->string('mail_copy')->nullable();
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
        Schema::dropIfExists('sales_extention');
    }
}
