<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class Budget extends Model
{
    //
    protected  $table = 'budget';

    private static function table(){
        return 'budget';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function department(){
        return $this->belongsTo('App\model\Department','dept_id','id')->withDefault();

    }
    public function account(){
        return $this->belongsTo('App\model\AccountChart','acct_id','id')->withDefault();

    }

    public function requestCategory(){
        return $this->belongsTo('App\model\RequestCategory','request_cat_id','id')->withDefault();

    }

    public function acctCat(){
        return $this->belongsTo('App\model\AccountCategory','acct_cat_id','id')->withDefault();

    }

    public function acctDetail(){
        return $this->belongsTo('App\model\AccountDetailType','acct_detail_id','id')->withDefault();

    }

    public function finYear(){
        return $this->belongsTo('App\model\FinancialYear','fin_year_id','id')->withDefault();

    }

    public function budgetData(){
        return $this->belongsTo('App\model\BudgetSummary','budget_id','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate('15');
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=','1')->orderBy('id','DESC')->get();

    }

    public static function getAllDataOneRow($row)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->get([$row]);

    }

    public static function getAllDataOrderByGroupBy()
    {
        return static::join('Account_category', 'Account_category.id', '=', 'budget.acct_cat_id')
            ->where('budget.status', '=','1')->groupBy('Account_category.category_name')
            ->orderBy('Account_category.category_name','ASC')->get();

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

    public static function specialColumnsOneRow($column, $post,$row)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get([$row]);

    }

    public static function specialColumnsAsc($column, $post)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->orderBy('id','ASC')->get();

    }

    public static function specialColumnsOrderByGroupBy($column,$post)
    {
        return static::join('Account_category', 'Account_category.id', '=', 'budget.acct_cat_id')
            ->where($column, '=',$post)
            ->where('budget.status', '=',Utility::STATUS_ACTIVE)->groupBy('Account_category.category_name')
            ->orderBy('Account_category.category_name','ASC')->get();

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

    public static function specialColumns2Asc($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','ASC')->get();

    }

    public static function specialColumns2OneRow($column, $post,$column2, $post2,$row)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->get([$row]);

    }

    public static function specialColumnsPage2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsPageOr2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->orWhere($column2, '=',$post2)->orderBy('id','DESC')->paginate(Utility::P35);

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
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)->get();

    }

    public static function massDataOneRow($column, $post,$row)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)->get([$row]);

    }

    public static function massDataOrderByGroupBy($column,$post)
    {
        return static::join('Account_category', 'Account_category.id', '=', 'budget.acct_cat_id')
            ->whereIn($column,$post)
            ->where('budget.status', '=',Utility::STATUS_ACTIVE)->groupBy('Account_category.category_name')
            ->orderBy('Account_category.category_name','ASC')->get();

    }


    public static function massData2($column, $post,$column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->whereIn($column2, $post2)->get();

    }

    public static function massData2OneRow($column, $post,$column2, $post2,$row)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->whereIn($column2, $post2)->get([$row]);

    }

    public static function massData2Condition($column,$post,$column2,$post2,$column3,$post3)
    {
        return static::whereIn($column,$post)->whereIn($column2,$post2)->whereIn($column3,$post3)
            ->where('budget.status', '=',Utility::STATUS_ACTIVE)->groupBy('Account_category.category_name')
            ->orderBy('Account_category.category_name','ASC')->get();

    }

    public static function massData3($column, $post,$column2, $post2,$column3, $post3)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->whereIn($column2, $post2)->whereIn($column3, $post3)->get();

    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->where($column2, $post2)->get();

    }

    public static function firstRow($column, $post)
    {
        //return Utility::firstRow(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->first();

    }

    public static function firstRow2($column, $post,$column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->first();

    }

    public static function firstRow3($column, $post,$column2, $post2,$column3, $post3)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->first();

    }

    public static function massUpdate($column, $arrayPost, $arrayDataUpdate=[])
    {
        return static::whereIn($column , $arrayPost)->update($arrayDataUpdate);

    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
    {

        return static::where($column , $postId)->update($arrayDataUpdate);

    }

    public static function defaultUpdate2($column, $postId, $column2, $postId2, $arrayDataUpdate=[])
    {

        return static::where($column , $postId)->where($column2 , $postId2)->update($arrayDataUpdate);

    }

    ///////////////////////////////

    public static function specialArrayColumnsPageDate($column, $post,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialArrayColumnsPageDate2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2,$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArrayColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2, $post2)->whereIn($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2, $post2)->where($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumns1PageDate2($column, $post, $column2, $post2,$dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, '=',$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumns2PageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->whereIn($column2, $post2)->where($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate($column, $post,$dateArray)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function paginateAllDataDate($dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();
        //return Utility::paginateAllData(self::table());

    }

}
