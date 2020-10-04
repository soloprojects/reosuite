<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('doc_name')->nullable();
            $table->longText('docs')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('project_docs');
    }
}
