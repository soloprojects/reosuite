<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class AccountJournal extends Model
{
    //
    protected  $table = 'account_journal';

    private static function table(){
        return 'account_journal';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function tax(){
        return $this->belongsTo('App\model\Tax','tax_id','id')->withDefault();

    }

    public function parentTransaction(){
        return $this->belongsTo('App\model\JournalExtension','extension_id','id')->withDefault();

    }

    public function account(){
        return $this->belongsTo('App\model\AccountChart','account_id','id')->withDefault();

    }

    public function chartData(){
        return $this->belongsTo('App\model\AccountChart','chart_id','id')->withDefault();

    }

    public function inventory(){
        return $this->belongsTo('App\model\Inventory','item_id','id')->withDefault();

    }
    
    public function taxVal(){
        return $this->belongsTo('App\model\Tax','tax_id','id')->withDefault();

    }

    public function transLocation(){
        return $this->belongsTo('App\model\TransLocation','loction_id','id')->withDefault();

    }

    public function transClass(){
        return $this->belongsTo('App\model\TransClass','class_id','id')->withDefault();

    }

    public function vendorCon(){
        return $this->belongsTo('App\model\VendorCustomer','vendor_customer','id')->withDefault();

    }

    public function dataStatus(){
        return $this->belongsTo('App\model\AccountStatus','journal_status','id')->withDefault();

    }

    public function transFormat(){
        return $this->belongsTo('App\model\JournalTransactionFormat','transaction_format','id')->withDefault();

    }

    public function currency(){
        return $this->belongsTo('App\model\Currency','trans_curr','id')->withDefault();

    }

    public function transCurr(){
        return $this->belongsTo('App\model\Currency','trans_curr','id')->withDefault();

    }

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();
    }

    public function accountType(){
        return $this->belongsTo('App\model\DebitCredit','debit_credit','id')->withDefault();

    }

    public function employee(){
        return $this->belongsTo('App\User','employee_id','id')->withDefault();

    }

    public function Category(){
        return $this->belongsTo('App\model\AccountCategory','acct_cat_id','id')->withDefault();

    }

    public function detail(){
        return $this->belongsTo('App\model\AccountDetailType','detail_id','id')->withDefault();

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
    
    public static function countData($column, $post)
    {
        return Utility::countData(self::table(),$column, $post);

    }

    public static function specialColumns($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

    }
	
	public static function specialColumnsPage($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsDatePage($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('post_date','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsPageAsc($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','ASC')->paginate(Utility::P35);

    }

    public static function specialColumns2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
		return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
		->where($column2, '=',$post2)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsCustom2($column, $post, $column2, $post2,$customFieldsArr)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
		return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
		->where($column2, '=',$post2)->orderBy('id','DESC')->get($customFieldsArr);

    }

    public static function specialColumnsSum2($column, $post, $column2, $post2)
    {        
		return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
		->where($column2, '=',$post2)->sum('trans_total');

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
    
    public static function specialColumnsSum3($column, $post, $column2, $post2, $column3, $post3)
    {        
		return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
		->where($column2, '=',$post2)->where($column3, '=',$post3)->sum('trans_total');

    }
	
	public static function specialColumnsPage3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
		return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
		->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsDate1($column, $post,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->whereBetween('post_date',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2,$post2)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    //THIS METHOD DOESNT ALLOW FIRST PARAMETERS AS ARRAY OF QUERY ITEM TO BE FETCHED
    public static function specialColumnsDate22($column, $post, $column2, $post2,$dateArray)
    {        
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->where($column2, $post2)->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {        
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate4($column, $post, $column2, $post2, $column3, $post3,$column4, $post4,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate5($column, $post, $column2, $post2, $column3, $post3,$column4, $post4, $column5, $post5,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)
            ->where($column5, $post5)->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDateTransaction($column, $post,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)            
            ->whereBetween('post_date',$dateArray)->orderBy('id','DESC')
            ->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2,$post2)->whereBetween('post_date',$dateArray)->orderBy('id','DESC')
            ->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')
            ->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction4($column, $post, $column2, $post2, $column3, $post3, $column4, $post4,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->where($column2, $post2)
        ->where($column3, $post3)->where($column4, $post4)->whereBetween('post_date',$dateArray)->orderBy('id','DESC')
            ->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction5($column, $post, $column2, $post2, $column3, $post3, $column4, $post4, $column5, $post5,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->where($column2, $post2)
        ->where($column3, $post3)->where($column4, $post4)->where($column5, $post5)
        ->whereBetween('post_date',$dateArray)->orderBy('id','DESC')
            ->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialArrayColumnsDateTransaction4($column, $post, $column2, $post2, $column3, $post3, $column4, $post4,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialArrayColumnsDateTransaction5($column, $post, $column2, $post2, $column3, $post3, $column4, $post4,$column5, $post5,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)->where($column5, $post5)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialArrayColumnsDateTransaction6($column, $post, $column2, $post2, $column3, $post3, $column4, $post4,$column5, $post5, $column6, $post6,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)->where($column5, $post5)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['extension_id','acct_cat_id','id','trans_total','transaction_type','cash_status','post_date','status','debit_credit','chart_id','item_id','vendor_customer','class_id','location_id','employee_id','created_by','updated_by','created_at','updated_at']);

    }

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(),$column, $post);

    }
    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);

    }

    public static function firstRow($column, $post)
    {
        //return Utility::firstRow(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
        ->orderBy('id','DESC')->first();

    }

    public static function firstRowAsc($column, $post)
    {
        //return Utility::firstRow(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
        ->orderBy('id','ASC')->first();

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


}
