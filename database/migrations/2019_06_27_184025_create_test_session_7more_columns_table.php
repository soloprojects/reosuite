<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestSession7moreColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_session', function (Blueprint $table) {
            $table->string('session_name',100);
            $table->integer('test_id');
            $table->integer('user_status');
            $table->integer('temp_user_status');
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_session', function (Blueprint $table) {
            //
            $table->dropColumn('session_name');
            $table->dropColumn('test_id');
            $table->dropColumn('user_status');
            $table->dropColumn('temp_user_status');
            $table->dropColumn('status');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }


}
