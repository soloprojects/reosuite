<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class VehicleServiceLog extends Model
{
    //
    protected  $table = 'vehicle_service_log';

    private static function table(){
        return 'vehicle_service_log';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'vehicle' => 'required',
        'mileage_in' => 'required',
        'mileage_out' => 'required',
        'workshop' => 'required',
        'service_date' => 'required',
        'service_type' => 'required',
        'total_bill' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function driver(){
        return $this->belongsTo('App\User','driver_id','id')->withDefault();

    }

    public function service(){
        return $this->belongsTo('App\model\VehicleServiceType','service_type','id')->withDefault();

    }

    public function vehicleDetail(){
        return $this->belongsTo('App\model\Vehicle','vehicle_id','id')->withDefault();

    }

    public function workshopDetail(){
        return $this->belongsTo('App\model\VehicleWorkshop','workshop','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate('15');
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->get();

    }

    public static function getAllDataByMonthYear($month,$year)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereMonth('service_date', $month)
            ->whereYear('service_date', $year)->orderBy('id','DESC')->get();

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

    public static function specialColumnsMass($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->orderBy('id','DESC')->get();

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

    public static function specialColumnsOr2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->orWhere($column2, '=',$post2)->orderBy('id','DESC')->get();

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

    public static function massDataDate3($column, $post, $dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->whereBetween('service_date',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function massDataColumnDate5($column, $post, $column2, $post2,$dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->whereIn($column2,$post2)->whereBetween('service_date',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function massDataColumnDate7($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->where($column2,$post2)->whereIn($column3,$post3)->whereBetween('service_date',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate($dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('service_date',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate3($column, $post,$dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->whereBetween('service_date',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate5($column, $post, $column2, $post2,$dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->where($column2,$post2)->whereBetween('service_date',$dateArray)->orderBy('id','DESC')->get();

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



}
