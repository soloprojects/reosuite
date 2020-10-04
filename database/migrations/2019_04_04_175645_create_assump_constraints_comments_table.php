<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssumpContraintsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assump_constraints_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('assump_id');
            $table->string('comment')->nullable();
            $table->integer('status');
            $table->integer('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('assump_constraints_comments');
    }
}
