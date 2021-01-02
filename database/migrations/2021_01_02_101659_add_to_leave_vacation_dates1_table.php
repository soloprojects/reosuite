<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToLeaveVacationDates1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_vacation_dates', function (Blueprint $table) {
            //
            $table->string('update_status',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_vacation_dates', function (Blueprint $table) {
            //
            $table->dropColumn('update_status');
        });
    }
}
