<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;
use Monolog\Handler\Curl\Util;

class TransferOrder extends Model
{
    //
    protected  $table = 'transfer_order';

    private static function table(){
        return 'transfer_order';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'code' => 'required',
        'name' => 'required',
        'address' => 'required',
        'shipment_bin' => 'required',
        'receipt_bin' => 'required',
    ];

    public static $mainRulesEdit = [
        'code' => 'required',
        'name' => 'required',
        'address' => 'required',
        'shipment_bin' => 'required',
        'receipt_bin' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id');

    }

    public function inventory(){
        return $this->belongsTo('App\model\Inventory','item_id','id');

    }

    public function warehouse(){
        return $this->belongsTo('App\model\Warehouse','to_whse','id');

    }

    public function to_zone(){
        return $this->belongsTo('App\model\Zone','to_zone','id');

    }

    public function to_bin(){
        return $this->belongsTo('App\model\Bin','to_bin','id');

    }

    public function open_shop_floor(){
        return $this->belongsTo('App\model\Bin','open_shop_floor_bin_code','id');

    }

    public function to_prod_bin(){
        return $this->belongsTo('App\model\Bin','to_prod_bin_code','id');

    }

    public function from_prod_bin(){
        return $this->belongsTo('App\model\Bin','from_prod_bin_code','id');

    }

    public function cross_dock(){
        return $this->belongsTo('App\model\Bin','cross_dock_bin_code','id');

    }

    public function to_assembly(){
        return $this->belongsTo('App\model\Bin','to_assembly_bin_code','id');

    }

    public function from_assembly(){
        return $this->belongsTo('App\model\Bin','from_assembly_bin_code','id');

    }

    public function assembly_to_order(){
        return $this->belongsTo('App\model\Bin','assembly_to_order_ship_bin_code','id');

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

}
