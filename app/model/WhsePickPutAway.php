<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;
use Monolog\Handler\Curl\Util;

class WhsePickPutAway extends Model
{
    //
    protected  $table = 'whse_pick_put_away';

    private static function table(){
        return 'whse_pick_put_away';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRulesEdit = [
        'warehouse' => 'required',
        'zone' => 'required',
        'bin' => 'required',
        'qty' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function assigned(){
        return $this->belongsTo('App\User','assigned_user','id')->withDefault();

    }

    public function inventory(){
        return $this->belongsTo('App\model\Inventory','item_id','id')->withDefault();

    }

    public function poItem(){
        return $this->belongsTo('App\model\PurchaseOrder','po_id','id')->withDefault();

    }

    public function poExtItem(){
        return $this->belongsTo('App\model\PoExtension','po_ext_id','id')->withDefault();

    }

    public function salesItem(){
        return $this->belongsTo('App\model\SalesOrder','sales_id','id')->withDefault();

    }

    public function salesExtItem(){
        return $this->belongsTo('App\model\SalesExtension','sales_ext_id','id')->withDefault();

    }

    public function warehouse(){
        return $this->belongsTo('App\model\Warehouse','to_whse','id')->withDefault();

    }

    public function zone(){
        return $this->belongsTo('App\model\Zone','to_zone','id')->withDefault();

    }

    public function bin(){
        return $this->belongsTo('App\model\Bin','to_bin','id')->withDefault();

    }

    public function receipt(){
        return $this->belongsTo('App\model\WarehouseReceipt','receipt_id','id')->withDefault();

    }

    public function shipment(){
        return $this->belongsTo('App\model\WarehouseReceipt','shipment_id','id')->withDefault();

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

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(),$column, $post);

    }

    public static function massDataPaginate($column, $post)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->paginate(Utility::P35);


    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);

    }

    public static function firstRow($column, $post)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->first();

    }

    public static function firstRow2($column, $post,$column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->where($column2, '=',$post2)->first();

    }

    public static function firstRow3($column, $post2,$column2, $post,$column3, $post3)
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

    public static function tenColumnSingleValue($post)
    {
        return Utility::tenColumnSingleValue(self::table(),'receipt_bin_code','adjust_bin_code','ship_bin_code',
            'open_shop_floor_bin_code','to_prod_bin_code','from_prod_bin_code','cross_dock_bin_code',
            'to_assembly_bin_code','from_assembly_bin_code','assembly_to_order_ship_bin_code',$post);
    }

    public static function searchWhsePutAway($value){
        return static::join('inventory', 'inventory.id', '=', 'whse_pick_put_away.item_id')
            ->join('warehouse', 'warehouse.id', '=', 'whse_pick_put_away.to_whse')
            ->join('po_extention', 'po_extention.id', '=', 'whse_pick_put_away.po_ext_id')
            ->join('users', 'users.id', '=', 'whse_pick_put_away.assigned_user')
            ->where('whse_pick_put_away.status', '=',Utility::STATUS_ACTIVE)
            ->where('whse_pick_put_away.pick_put_type', '=',Utility::PUT_AWAY)
            ->where('whse_pick_put_away.pick_put_status', '=',Utility::ZERO)

            ->where(function ($query) use($value){
                $query->where('inventory.item_name','LIKE','%'.$value.'%')
                    ->orWhere('warehouse.name','LIKE','%'.$value.'%')
                    ->orWhere('po_extention.po_number','LIKE','%'.$value.'%')
                    ->orWhere('users.firstname','LIKE','%'.$value.'%')
                    ->orWhere('users.lastname','LIKE','%'.$value.'%');
            })->get();
    }

    public static function searchWhsePick($value){
        return static::join('inventory', 'inventory.id', '=', 'whse_pick_put_away.item_id')
            ->join('warehouse', 'warehouse.id', '=', 'whse_pick_put_away.to_whse')
            ->join('po_extention', 'po_extention.id', '=', 'whse_pick_put_away.po_ext_id')
            ->join('users', 'users.id', '=', 'whse_pick_put_away.assigned_user')
            ->where('whse_pick_put_away.status', '=',Utility::STATUS_ACTIVE)
            ->where('whse_pick_put_away.pick_put_type', '=',Utility::PICK)
            ->where('whse_pick_put_away.pick_put_status', '=',Utility::ZERO)

            ->where(function ($query) use($value){
                $query->where('inventory.item_name','LIKE','%'.$value.'%')
                    ->orWhere('warehouse.name','LIKE','%'.$value.'%')
                    ->orWhere('po_extention.po_number','LIKE','%'.$value.'%')
                    ->orWhere('users.firstname','LIKE','%'.$value.'%')
                    ->orWhere('users.lastname','LIKE','%'.$value.'%');
            })->get();
    }

}
