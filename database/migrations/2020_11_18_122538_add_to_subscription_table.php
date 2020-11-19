<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription', function (Blueprint $table) {
            //
            $table->integer('memory_status')->default(0)->change();
            $table->integer('active_status')->default(0)->change();
            $table->string('apps')->default('["1"]')->change();
            $table->integer('user_count')->default(0)->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription', function (Blueprint $table) {
            //
            $table->integer('memory_status')->default(0)->change();
            $table->integer('active_status')->default(0)->change();
            $table->string('apps')->default('["1"]')->change();
            $table->integer('user_count')->default(0)->change();
        });
    }
}
