<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToCrmOpportunity2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_opportunity', function (Blueprint $table) {
            //
            $table->integer('opportunity_status')->nullable();
            $table->text('lost_reason')->nullable();
            $table->integer('sales_cycle_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crm_opportunity', function (Blueprint $table) {
            //
            $table->dropColumn('opportunity_status');
            $table->dropColumn('lost_reason');
            $table->dropColumn('sales_cycle_id');

        });
    }

}
