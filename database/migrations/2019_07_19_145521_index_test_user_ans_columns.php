<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexTestUserAnsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('test_user_ans', function (Blueprint $table) {
            //
            $table->index(['cat_id','test_id','session_id','user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('test_user_ans', function (Blueprint $table) {
            //
            $table->dropColumn(['cat_id','test_id','session_id','user_id', 'created_at']);
        });
    }
}
