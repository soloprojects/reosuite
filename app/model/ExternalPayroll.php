<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class ExternalPayroll extends Model

{
    //
    protected  $table = 'external_payroll';

    private static function table(){
        return 'external_payroll';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'extra_amount' => 'sometimes|nullable|numeric',
        'bonus_deduct_type' => 'required|numeric',
        'date' => 'required',
        'month' => 'required',
        'year' => 'required'
    ];

    public static $mainRulesEdit = [
        'extra_amount' => 'sometimes|nullable|numeric',
        'bonus_deduct_type' => 'required|numeric',
        'month' => 'required',
        'year' => 'required'
    ];

    public static $processRules = [
        'date' => 'required',
    ];

    public function department(){
        return $this->belongsTo('App\model\Department','dept_id','id')->withDefault();
    }

    public function position(){
        return $this->belongsTo('App\model\Position','position_id','id')->withDefault();
    }

    public function salary(){
        return $this->belongsTo('App\model\SalaryStructure','salary_id','id')->withDefault();
    }

    public function currency(){
        return $this->belongsTo('App\model\Currency','curr_id','id')->withDefault();

    }

    public function userDetail(){
        return $this->belongsTo('App\model\TempUsers','user_id','id')->withDefault();
    }

    public function user_c(){
        return $this->belongsTo('App\model\TempUsers','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\model\TempUsers','updated_by','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P50);
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

    public static function countData2($column, $post,$column2, $post2)
    {
        return Utility::countData2(self::table(),$column, $post,$column2, $post2);

    }

    public static function countData3($column, $post,$column2, $post2,$column3, $post3)
    {
        return Utility::countData3(self::table(),$column, $post,$column2, $post2,$column3, $post3);

    }

    public static function getByDate($dateColumn,$dateArr)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
        ->whereBetween($dateColumn,$dateArr)->orderBy('id','DESC')->get();

    }

    public static function specialColumns($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate($column, $post,$dateColumn,$dateArr)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
        ->whereBetween($dateColumn,$dateArr)->orderBy('id','DESC')->get();

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

    public static function specialColumns4($column, $post, $column2, $post2, $column3, $post3, $column4, $post4)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->where($column4, '=',$post4)->orderBy('id','DESC')->get();

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

    public static  function sumColumnDataCondition($column, $post,$sumColumn){
        Utility::sumColumnDataCondition(self::table(),$column, $post,$sumColumn);
    }

}
