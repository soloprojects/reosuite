<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Utility;

class User extends Authenticatable
{
    use Notifiable;
    protected  $table = 'users';

    private static function table(){
        return 'users';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public static $mainRules = [
        'email' => 'email|unique:users,email',
        'other_mail' => 'sometimes|email|unique:users,local_email',
        'role' => 'required',
        'firstname' => 'required',
        'photo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif',
        'sign' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif',
        'lastname' => 'required',
        'othername' => 'sometimes|nullable',
        'gender' => 'required',
        'birthdate' => 'sometimes|nullable|date',
        'employ_date' => 'sometimes|nullable|date',
        'phone' => 'sometimes|nullable|numeric',
        'employ_type' => 'required',
        'position' => 'required',
        'department' => 'required',
    ];

    public static $mainRulesEdit = [
        'email' => 'email',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
        'other_mail' => 'email',
        'role' => 'required',
        'firstname' => 'required',
        'photo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif|max:1000',
        'sign' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif|max:1000',
        'lastname' => 'required',
        'othername' => 'sometimes|nullable',
        'gender' => 'required',
        'birthdate' => 'sometimes|nullable|date',
        'employ_date' => 'sometimes|nullable|date',
        'phone' => 'sometimes|nullable|numeric',
        'employ_type' => 'required',
        'position' => 'required',
        'department' => 'required',
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

    public function roles(){
        return $this->belongsTo('App\model\Roles','role','id')->withDefault();
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
    public static function paginateData($column, $post)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate('15');
        //return Utility::paginateData(self::table(),$column, $post);

    }

    public static function countData($column, $post)
    {
        return Utility::countData(self::table(),$column, $post);

    }

    public static function countAll()
    {
        return Utility::countAll(self::table());

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
            ->orderBy('id','DESC')->get();

    }

    public static function massDataMassConditionPaginate($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->whereIn($column2,$post2)
            ->orderBy('id','DESC')->paginate(Utility::P35);

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

    public static function searchUser($value){
        return static::leftJoin('department', 'department.id', '=', 'users.dept_id')
            ->leftJoin('salary', 'salary.id', '=', 'users.salary_id')
            ->leftJoin('position', 'position.id', '=', 'users.position_id')
            ->leftJoin('roles', 'roles.id', '=', 'users.role')
            ->where('users.status', '=','1')
            ->where(function ($query) use($value){
                $query->where('users.lastname','LIKE','%'.$value.'%')
                    ->orWhere('users.firstname','LIKE','%'.$value.'%') ->orWhere('users.phone','LIKE','%'.$value.'%')
                    ->orWhere('users.address','LIKE','%'.$value.'%')->orWhere('users.blood_group','LIKE','%'.$value.'%')
                    ->orWhere('users.employ_date','LIKE','%'.$value.'%')->orWhere('users.employ_type','LIKE','%'.$value.'%')
                    ->orWhere('users.employ_type','LIKE','%'.$value.'%')->orWhere('users.email','LIKE','%'.$value.'%')
                    ->orWhere('users.state','LIKE','%'.$value.'%')->orWhere('users.local_govt','LIKE','%'.$value.'%')
                    ->orWhere('users.sex','LIKE','%'.$value.'%')->orWhere('users.active_status','LIKE','%'.$value.'%')
                    ->orWhere('users.nationality','LIKE','%'.$value.'%')->orWhere('users.othername','LIKE','%'.$value.'%')
                    ->orWhere('users.other_email','LIKE','%'.$value.'%')->orWhere('users.marital','LIKE','%'.$value.'%')
                    ->orWhere('users.next_kin','LIKE','%'.$value.'%')->orWhere('users.emergency_name','LIKE','%'.$value.'%')
                    ->orWhere('salary.salary_name','LIKE','%'.$value.'%')->orWhere('position.position_name','LIKE','%'.$value.'%')
                    ->orWhere('department.dept_name','LIKE','%'.$value.'%')->orWhere('roles.role_name','LIKE','%'.$value.'%');
            })->get();
    }

    public static function searchEnabledUser($value){
        return static::leftJoin('department', 'department.id', '=', 'users.dept_id')
            ->leftJoin('salary', 'salary.id', '=', 'users.salary_id')
            ->leftJoin('position', 'position.id', '=', 'users.position_id')
            ->leftJoin('roles', 'roles.id', '=', 'users.role')
            ->where('users.active_status', '=','1')
            ->where('users.status', '=','1')
            ->where(function ($query) use($value){
                $query->where('users.lastname','LIKE','%'.$value.'%')
                    ->orWhere('users.firstname','LIKE','%'.$value.'%') ->orWhere('users.phone','LIKE','%'.$value.'%')
                    ->orWhere('users.address','LIKE','%'.$value.'%')->orWhere('users.blood_group','LIKE','%'.$value.'%')
                    ->orWhere('users.employ_date','LIKE','%'.$value.'%')->orWhere('users.employ_type','LIKE','%'.$value.'%')
                    ->orWhere('users.employ_type','LIKE','%'.$value.'%')->orWhere('users.email','LIKE','%'.$value.'%')
                    ->orWhere('users.state','LIKE','%'.$value.'%')->orWhere('users.local_govt','LIKE','%'.$value.'%')
                    ->orWhere('users.sex','LIKE','%'.$value.'%')->orWhere('users.active_status','LIKE','%'.$value.'%')
                    ->orWhere('users.nationality','LIKE','%'.$value.'%')->orWhere('users.othername','LIKE','%'.$value.'%')
                    ->orWhere('users.other_email','LIKE','%'.$value.'%')->orWhere('users.marital','LIKE','%'.$value.'%')
                    ->orWhere('users.next_kin','LIKE','%'.$value.'%')->orWhere('users.emergency_name','LIKE','%'.$value.'%')
                    ->orWhere('salary.salary_name','LIKE','%'.$value.'%')->orWhere('position.position_name','LIKE','%'.$value.'%')
                    ->orWhere('department.dept_name','LIKE','%'.$value.'%')->orWhere('roles.role_name','LIKE','%'.$value.'%');
            })->get();
    }

    public static function birthday()
    {

        return static::whereRaw(' DAYOFYEAR(curdate()) <= DAYOFYEAR(dob) AND DAYOFYEAR(curdate()) + 7 >=  dayofyear(dob)')
            ->where('status',Utility::STATUS_ACTIVE)
            ->where('active_status',Utility::STATUS_ACTIVE)
            ->orderByRaw('DAYOFYEAR(dob)')
            ->get();

    }

}
