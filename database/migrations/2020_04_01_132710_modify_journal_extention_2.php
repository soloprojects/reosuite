<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyJournalExtention2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_extention', function (Blueprint $table) {
            //
            $table->renameColumn('excl_tax_discount','tax_total');
            $table->renameColumn('excl_tax_discount_trans','tax_trans');            
            $table->renameColumn('sum_trans','trans_total');            
            $table->string('tax_perct',5)->nullable();
            $table->integer('tax_type')->nullable();
            $table->string('default_curr',15)->nullable();
            $table->string('trans_curr',15)->nullable();
            $table->string('mails')->nullable();
            $table->string('mail_copy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_extention', function (Blueprint $table) {
            //
            $table->renameColumn('excl_tax_discount','tax_total');
            $table->renameColumn('excl_tax_discount_trans','tax_trans');   
            $table->renameColumn('sum_trans','trans_total');            
            $table->dropColumn('tax_perct');
            $table->dropColumn('tax_type');
            $table->dropColumn('default_curr');
            $table->dropColumn('trans_curr');
            $table->dropColumn('mails');
            $table->dropColumn('mails_copy');
        });
    }

}
