<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToHelpDeskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helpdesk', function (Blueprint $table) {
            //
            $table->integer('dept_id');
            $table->string('response_rate')->nullable();
            $table->text('feedback')->nullable();
            $table->string('response_dates')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('helpdesk', function (Blueprint $table) {
            //
            $table->dropColumn('dept_id');
            $table->dropColumn('response_rate');
            $table->dropColumn('response_rate');
            $table->dropColumn('response_dates');
        });
    }
}
