<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class Inventory extends Model
{
    //
    protected  $table = 'inventory';

    private static function table(){
        return 'inventory';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'name' => 'required',
        'unit_measure' => 'required',
        'item_category' => 'required',
        'pref_vendor' => 'required',
        'income_account' => 'required',
        'expense_account' => 'required',
        'inventory_account' => 'required',
        'unit_cost' => 'required',
        'inventory_type' => 'required',
        'storage_type' => 'required',
    ];

    public static $mainRulesEdit = [
        'name' => 'required',
        'unit_measure' => 'required',
        'item_category' => 'required',
        'pref_vendor' => 'required',
        'income_account' => 'required',
        'expense_account' => 'required',
        'inventory_account' => 'required',
        'unit_cost' => 'required',
        'inventory_type' => 'required',
        'storage_type' => 'required',
    ];

    public function category(){
        return $this->belongsTo('App\model\InventoryCategory','category_id','id')->withDefault();

    }

    public function inv_type(){
        return $this->belongsTo('App\model\InventoryType','inventory_type','id')->withDefault();

    }

    public function expense(){
        return $this->belongsTo('App\model\AccountChart','expense_account','id')->withDefault();

    }

    public function income(){
        return $this->belongsTo('App\model\AccountChart','income_account','id')->withDefault();

    }

    public function inventory(){
        return $this->belongsTo('App\model\AccountChart','inventory_account','id')->withDefault();

    }

    public function bomItem(){
        return $this->belongsTo('App\model\Inventory','inventory_id','id')->withDefault();

    }

    public function vendor(){
        return $this->belongsTo('App\model\VendorCustomer','pref_vendor','id')->withDefault();

    }

    public function unitMeasure(){
        return $this->belongsTo('App\model\UnitMeasure','unit_measure','id')->withDefault();

    }

    public function putAwayTemp(){
        return $this->belongsTo('App\model\PutAwayTemplate','put_away_template','id')->withDefault();

    }

    public function invCount(){
        return $this->belongsTo('App\model\PhysicalInvCount','invt_count_period','id')->withDefault();

    }

    public function currency(){
        return $this->belongsTo('App\model\Currency','curr_id','id')->withDefault();

    }

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id');

    }

    public function bomData(){
        return $this->hasMany('App\model\InventoryBom','inventory_id','id');

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P35);
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

    public static function tenColumnSingleValue($post)
    {
        return Utility::tenColumnSingleValue(self::table(),'receipt_bin_code','adjust_bin_code','ship_bin_code',
            'open_shop_floor_bin_code','to_prod_bin_code','from_prod_bin_code','cross_dock_bin_code',
            'to_assembly_bin_code','from_assembly_bin_code','assembly_to_order_ship_bin_code',$post);
    }

    public static function searchInventory($value){
        return static::where('inventory.status', '=','1')
            ->where(function ($query) use($value){
                $query->where('inventory.item_name','LIKE','%'.$value.'%')
                    ->orWhere('inventory.search_key','LIKE','%'.$value.'%') ->orWhere('inventory.item_no','LIKE','%'.$value.'%');
            })->get();
    }

}
