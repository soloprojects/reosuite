<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class RFQ extends Model
{
    //
    protected  $table = 'rfq';

    private static function table(){
        return 'rfq';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'due_date' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function userDetail(){
        return $this->belongsTo('App\User','assigned_user','id')->withDefault();

    }

    public function vendorCon(){
        return $this->belongsTo('App\model\VendorCustomer','vendor','id')->withDefault();

    }

    public function currency(){
        return $this->belongsTo('App\model\Currency','trans_curr','id')->withDefault();

    }

    public function transCurr(){
        return $this->belongsTo('App\model\Currency','trans_curr','id')->withDefault();

    }

    public function assigned(){
        return $this->belongsTo('App\User','assigned_user','id')->withDefault();

    }

    public function po(){
        return $this->hasMany('App\model\PurchaseOrder','uid','po_uid');

    }

    public function account(){
        return $this->belongsTo('App\model\AccountChart','account_id','id')->withDefault();

    }

    public function inventory(){
        return $this->belongsTo('App\model\Inventory','item_id','id')->withDefault();

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

    public static function massData($column, $post = [])
    {
        //return Utility::massData(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->get();

    }

    public static function massDataPaginate($column, $post = [])
    {
        //return Utility::massData(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=',$post2)
            ->orderBy('id','DESC')->get();

    }

    public static function massDataConditionPaginate($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=',$post2)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massDataMassCondition($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->whereIn($column2,$post2)
            ->orderBy('id','DESC')->get(Utility::P35);

    }

    public static function massDataMassConditionPaginate($column, $post, $column2, $post2)
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

    public static function deleteItem($postId)
    {
        return Utility::deleteItem(self::table(),$postId);

    }

    public static function deleteItemData($id,$postId)
    {
        return Utility::deleteItemData(self::table(),$id,$postId);

    }

    public static function searchPo($value){
        return static::where('po_extention.status', '=','1')
            ->join('vendor_customer', 'vendor_customer.id', '=', 'po_extention.vendor')
            ->where(function ($query) use($value){
                $query->where('po_extention.po_number','LIKE','%'.$value.'%')->orWhere('vendor_customer.name','LIKE','%'.$value.'%')
                    ->orWhere('po_extention.vendor_invoice_no','LIKE','%'.$value.'%')->orWhere('po_extention.assigned_user','LIKE','%'.$value.'%')
                    ->orWhere('po_extention.ship_method','LIKE','%'.$value.'%')->orWhere('po_extention.ship_agent','LIKE','%'.$value.'%')
                    ->orWhere('po_extention.ship_to_country','LIKE','%'.$value.'%')->orWhere('po_extention.ship_address','LIKE','%'.$value.'%')
                    ->orWhere('po_extention.purchase_status','LIKE','%'.$value.'%')->orWhere('po_extention.ship_to_contact','LIKE','%'.$value.'%')
                    ->orWhere('po_extention.ship_agent','LIKE','%'.$value.'%');
            })->get();
    }

}
