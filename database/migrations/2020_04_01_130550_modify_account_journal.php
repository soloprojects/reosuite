<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAccountJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_journal', function (Blueprint $table) {
            //
            $table->renameColumn('excl_tax_discount','tax_amount');
            $table->renameColumn('excl_tax_discount_trans','tax_amount_trans');
            $table->renameColumn('amount','extended_amount');
            $table->renameColumn('trans_amount','extended_amount_trans');  
            $table->renameColumn('trans_unit_cost','unit_cost_trans');            
            $table->string('tax_perct',5)->nullable();
            $table->string('discount_amount',15)->nullable();
            $table->string('discount_amount_trans',15)->nullable();
            $table->string('unit_measurement',100)->nullable();
            $table->string('quantity',15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_journal', function (Blueprint $table) {
            //
            $table->renameColumn('excl_tax_discount','tax_amount');
            $table->renameColumn('excl_tax_discount_trans','tax_amount_trans'); 
            $table->renameColumn('amount','extended_amount');
            $table->renameColumn('trans_amount','extended_amount_trans'); 
            $table->renameColumn('trans_unit_cost','unit_cost_trans');            
            $table->dropColumn('tax_perct');
            $table->dropColumn('discount_amount');
            $table->dropColumn('discount_amount_trans');
            $table->dropColumn('unit_measurement');
            $table->dropColumn('quantity');
        });
    }

}

