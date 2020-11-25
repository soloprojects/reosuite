<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToJobApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            //
            $table->integer('dept_id')->nullable();
            $table->integer('position_id')->nullable();
            $table->string('salary_expectation','20')->nullable();
            $table->string('location','100')->nullable();
            $table->string('remark','100')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            //
            $table->dropColumn('dept_id');
            $table->dropColumn('position_id');
            $table->dropColumn('salary_expectation');
            $table->dropColumn('location');
            $table->dropColumn('remark');
        });
    }
}
