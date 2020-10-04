<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class DebitCredit extends Model
{
    //
    protected  $table = 'debit_credit';

    private static function table(){
        return 'debit_credit';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


}
