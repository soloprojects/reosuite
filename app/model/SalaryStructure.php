<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class SalaryStructure extends Model
{
    //
    protected  $table = 'salary';

    private static function table(){
        return 'salary';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'salary_name' => 'required',
        'salary_desc' => 'required',
        'tax_system' => 'required',
        'net_pay' => 'required',
        'gross_pay' => 'required',
    ];

    public function tax(){
        return $this->belongsTo('App\model\Tax','tax_id','id');

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

}
