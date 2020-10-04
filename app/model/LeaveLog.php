<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class LeaveLog extends Model
{
    //
    protected  $table = 'leave_log';

    private static function table(){
        return 'leave_log';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'leave_description' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'leave_type' => 'required',
    ];

    public static $hrRules = [
        'start_date' => 'required',
        'end_date' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id');

    }

    public function department(){
        return $this->belongsTo('App\model\Department','dept_id','id');

    }

    public function approval(){
        return $this->belongsTo('App\model\HrisApprovalSys','approval_id','id');

    }

    public function leaveType(){
        return $this->belongsTo('App\model\LeaveType','leave_type','id');

    }

    public function requestUser(){
        return $this->belongsTo('App\user','request_user','id');

    }

    public function denyUser(){
        return $this->belongsTo('App\user','deny_user','id');

    }


    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P35);
        //return Utility::paginateAllData(self::table());

    }

    public static function customDataPaginate($numberOfItems)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate($numberOfItems);

    }

    public static function customDataPaginate2($column, $post,$numberOfItems)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->orderBy('id','DESC')->paginate($numberOfItems);

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

}
