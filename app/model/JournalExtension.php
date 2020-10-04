<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class JournalExtension extends Model
{
    //
    protected  $table = 'journal_extention';

    private static function table(){
        return 'journal_extention';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $invoiceRules = [

        'pref_customer' => 'required',
        'posting_date' => 'required',
        'terms' => 'required',
        'status' => 'required',
    ];

    public static $journalEntryRules = [

        'posting_date' => 'required',
        'cash_transaction_status' => 'required',
    ];

    public static $paymentReceiptRules = [

        'posting_date' => 'required',
        'receipt_account' => 'required',
        'total_amount' => 'required',
    ];

    public static $billPaymentRules = [

        'posting_date' => 'required',
        'payment_account' => 'required',
        'total_amount' => 'required',
    ];

    public static $cashReceiptRules = [

        'pref_customer' => 'required',
        'posting_date' => 'required',
        'receipt_account' => 'required',
    ];

    public static $refundReceiptRules = [

        'pref_customer' => 'required',
        'posting_date' => 'required',
        'refund_from_account' => 'required',
    ];

    public static $creditMemoRules = [

        'pref_customer' => 'required',
        'posting_date' => 'required',
        'status' => 'required',
    ];

    public static $billRules = [

        'pref_vendor' => 'required',
        'posting_date' => 'required',
        'terms' => 'required',
        'status' => 'required',
    ];

    public static $expenseRules = [

        'pref_vendor' => 'required',
        'posting_date' => 'required',
        'payment_account' => 'required',
    ];

    public static $vendorCreditRules = [

        'pref_vendor' => 'required',
        'posting_date' => 'required',
        'status' => 'required',
    ];

    public function transTerms(){
        return $this->belongsTo('App\model\JournalTransactionTerms','terms','id')->withDefault();

    }

    public function transLocation(){
        return $this->belongsTo('App\model\TransLocation','location_id','id')->withDefault();

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

    public function employee(){
        return $this->belongsTo('App\User','employee_id','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate('100');
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
            ->where($column2, '=',$post2)->orderBy('id','DESC')->paginate(Utility::P100);

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

    public static function specialColumnsDate($column, $post,$date)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where('due_date','<',$date)->orderBy('id','DESC')
            ->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDate2($column, $post,$column2, $post2,$date)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
        ->whereIn($column,$post)->where($column2,$post2)
            ->where('due_date','<',$date)->orderBy('id','DESC')
            ->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDate3($column, $post,$column2, $post2,$column3, $post3,$date)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
        ->whereIn($column,$post)->where($column2,$post2)->where($column3,$post3)
            ->where('due_date','<',$date)->orderBy('id','DESC')
            ->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDate4($column, $post,$column2, $post2,$column3, $post3,$column4, $post4,$date)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->whereIn($column,$post)->where($column2,$post2)->where($column3,$post3)->where($column4,$post4)
            ->where('due_date','<',$date)->orderBy('id','DESC')
            ->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction($column, $post,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereBetween('post_date',$dateArray)->orderBy('id','DESC')
            ->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2,$post2)->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction4($column, $post, $column2, $post2, $column3, $post3, $column4, $post4,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction5($column, $post, $column2, $post2, $column3, $post3, $column4, $post4,$column5, $post5,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)->where($column5, $post5)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function specialColumnsDateTransaction6($column, $post, $column2, $post2, $column3, $post3, $column4, $post4,$column5, $post5, $column6, $post6,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, $post2)->where($column3, $post3)->where($column4, $post4)->where($column5, $post5)
            ->whereBetween('post_date',$dateArray)
            ->orderBy('id','DESC')->get(['balance','balance_trans','journal_status','due_date','id','trans_total','transaction_type','cash_status','post_date','status','vendor_customer','class_id','location_id','employee_id','file_no','created_by','updated_by','created_at','updated_at']);

    }

    public static function massData($column, $post = [])
    {
        //return Utility::massData(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->get();

    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);

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

    public static function sumColumnDataCondition2($column, $post,$column2, $post2, $sumColumn)
    {
        return Utility::sumColumnDataCondition2(self::table(),$column, $post,$column2, $post2,$sumColumn);

    }


    public static function sumColumnDataCondition($column, $post, $sumColumn)
    {
        return Utility::sumColumnDataCondition(self::table(),$column, $post,$sumColumn);

    }

    public static function massDataPaginate($column, $post = [])
    {        
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->paginate(Utility::P100);

    }

    public static function search($value,$transactionType){
        return static::where('journal_extention.status', '=','1')
                     ->where('journal_extention.transaction_type',$transactionType)
            ->leftJoin('vendor_customer', 'vendor_customer.id', '=', 'journal_extention.vendor_customer')
            ->leftJoin('trans_location', 'trans_location.id', '=', 'journal_extention.location_id')
            ->leftJoin('trans_class', 'trans_class.id', '=', 'journal_extention.class_id')
            ->leftJoin('account_status', 'account_status.id', '=', 'journal_extention.journal_status')
            ->where(function ($query) use($value){
                $query->where('journal_extention.file_no','LIKE','%'.$value.'%')
                    ->orWhere('journal_extention.reference_no','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.name','LIKE','%'.$value.'%')
                    ->orWhere('journal_extention.id','LIKE','%'.$value.'%')
                    ->orWhere('trans_location.location','LIKE','%'.$value.'%')
                    ->orWhere('trans_class.class_name','LIKE','%'.$value.'%')
                    ->orWhere('account_status.name','LIKE','%'.$value.'%');
            })->get(['journal_extention.uid','journal_extention.file_no','journal_extention.id','account_status.name','trans_class.class_name','trans_location.location','vendor_customer.name']);
    }

    public static function searchJournal($value){
        return static::where('journal_extention.status', '=','1')
            ->leftJoin('vendor_customer', 'vendor_customer.id', '=', 'journal_extention.vendor_customer')
            ->leftJoin('trans_location', 'trans_location.id', '=', 'journal_extention.location_id')
            ->leftJoin('trans_class', 'trans_class.id', '=', 'journal_extention.class_id')
            ->leftJoin('account_status', 'account_status.id', '=', 'journal_extention.journal_status')
            ->where(function ($query) use($value){
                $query->where('journal_extention.id','LIKE','%'.$value.'%')
                    ->orWhere('journal_extention.file_no','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.name','LIKE','%'.$value.'%')                    
                    ->orWhere('trans_location.location','LIKE','%'.$value.'%')
                    ->orWhere('trans_class.class_name','LIKE','%'.$value.'%')
                    ->orWhere('account_status.name','LIKE','%'.$value.'%');
            })->get(['journal_extention.uid','journal_extention.file_no','journal_extention.id','account_status.name','trans_class.class_name','trans_location.location','vendor_customer.name']);
    }

    public static function searchOpenTransaction($value,$transactionType){
        return static::where('journal_extention.status', '=','1')
                     ->where('journal_extention.transaction_type',$transactionType)
                     ->where('journal_extention.journal_status',Utility::OPEN_ACCOUNT_STATUS)
            ->leftJoin('vendor_customer', 'vendor_customer.id', '=', 'journal_extention.vendor_customer')
            ->leftJoin('trans_location', 'trans_location.id', '=', 'journal_extention.location_id')
            ->leftJoin('trans_class', 'trans_class.id', '=', 'journal_extention.class_id')
            ->leftJoin('account_status', 'account_status.id', '=', 'journal_extention.journal_status')
            ->where(function ($query) use($value){
                $query->where('journal_extention.file_no','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.name','LIKE','%'.$value.'%')
                    ->orWhere('journal_extention.id','LIKE','%'.$value.'%')
                    ->orWhere('trans_location.location','LIKE','%'.$value.'%')
                    ->orWhere('trans_class.class_name','LIKE','%'.$value.'%')
                    ->orWhere('account_status.name','LIKE','%'.$value.'%');
            })->get(['journal_extention.uid','journal_extention.file_no','journal_extention.id','account_status.name','trans_class.class_name','trans_location.location','vendor_customer.name']);
    }


}
