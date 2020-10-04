<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class AccountChart extends Model
{
    //
    protected  $table = 'account_chart';

    private static function table(){
        return 'account_chart';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'account_category' => 'required',
        'detail_type' => 'required',
        'currency' => 'required',
        'account_name' => 'required',
        'account_number' => 'sometimes|nullable|numeric',
        'depreciation_date' => 'sometimes|nullable',
        'cost_date' => 'sometimes|nullable',
        'original_cost' => 'sometimes|nullable',
        'depreciation' => 'sometimes|nullable',
    ];

    public static $mainRulesEdit = [

        'currency' => 'required',
        'account_name' => 'required',
        'account_no' => 'sometimes|numeric',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function category(){
        return $this->belongsTo('App\model\AccountCategory','acct_cat_id','id')->withDefault();

    }

    public function detail(){
        return $this->belongsTo('App\model\AccountDetailType','detail_id','id')->withDefault();

    }

    public function transCurr(){
        return $this->belongsTo('App\model\Currency','trans_curr','id')->withDefault();

    }

    public function chartCurr(){
        return $this->belongsTo('App\model\Currency','curr_id','id')->withDefault();

    }

    public function journalMany(){
        return $this->hasMany('App\model\AccountJournal','chart_id','id');

    }

    public function journal(){
        return $this->belongsTo('App\model\AccountJournal','chart_id','id');

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P50);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->get();

    }

    public static function getAllDataOrderByGroupBy()
    {
        return static::join('AccountCategory', 'AccountCategory.id', '=', 'AccountChart.acct_cat_id')
            ->where('status', '=',Utility::STATUS_ACTIVE)->groupBy('AccountCategory.category_name')
            ->orderBy('AccountCategory.category_name','ASC')->get();

    }

    public static function countData($column, $post)
    {
        return Utility::countData(self::table(),$column, $post);

    }

    public static function specialColumns($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumns2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumns3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(),$column, $post);

    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return static::whereIn($column, $post)->where($column2, $post2)->where('status', Utility::STATUS_ACTIVE)
        ->orderBy('acct_name','ASC')->get();

    }

    public static function massDataAlphaOrder($column, $post)
    {
        return static::join('account_category', 'account_category.id', '=', 'Account_chart.acct_cat_id')
            ->select('account_category.category_name','account_chart.acct_cat_id','account_chart.acct_name','account_chart.detail_id','account_chart.acct_no','account_chart.id')
        ->where('account_chart.status', Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->orderBy('account_category.category_name','ASC')->get();

    }

    public static function massDataMassCondition($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->whereIn($column2,$post2)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function firstRow($column, $post)
    {
        //return Utility::firstRow(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->first();

    }

    public static function firstRow2($column, $post,$column2, $post2)
    {
        return Utility::firstRow2(self::table(),$column, $post,$column2, $post2);

    }

    public static function massUpdate($column, $arrayPost, $arrayDataUpdate=[])
    {
        return static::whereIn($column , $arrayPost)->update($arrayDataUpdate);

    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
    {

        return static::where($column , $postId)->update($arrayDataUpdate);

    }

    public static function sumColumnDataCondition3($column, $post,$column2, $post2, $column3, $post3, $sumColumn)
    {
        return Utility::sumColumnDataCondition3(self::table(),$column, $post,$column2, $post2,$column3, $post3,$sumColumn);

    }

    public static function searchAccount($value){
        return static::where('account_chart.status', '=','1')
            
            ->where(function ($query) use($value){
                $query->where('account_chart.acct_name','LIKE','%'.$value.'%')
                ->orWhere('account_chart.acct_no','LIKE','%'.$value.'%');
            })->get();
    }


}
