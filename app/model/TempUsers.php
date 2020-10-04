<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Utility;
use Illuminate\Support\Facades\Auth;

class TempUsers extends Authenticatable
{
    //
    use Notifiable;
    protected $guard = 'admin';

    protected  $table = 'temp_users';

    private static function table(){
        return 'temp_users';
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
        'email' => 'required|email|unique:users,email',
        'role' => 'required',
        'firstname' => 'required',
        'photo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif',
        'cv' => 'sometimes|mimes:docx,doc,pdf|max:2048',
        'lastname' => 'required',
        'othername' => 'sometimes|nullable',
        'birthdate' => 'sometimes|nullable|date',
        'phone' => 'sometimes|nullable|numeric',
        'unit' => 'required',
    ];

    public static $signupRules = [
        'email' => 'required|email|unique:temp_users,email',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
        'firstname' => 'required',
        'lastname' => 'required',
        'unit' => 'required',
        'pin_code' => 'required',

    ];

    public static $clientRules = [
        'email' => 'required|email|unique:temp_users,email',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
        'company_name' => 'required',
        'country' => 'required',
        'unit' => 'required',
        'pin_code' => 'required',
    ];

    public static $mainRulesEdit = [
        'email' => 'required|email',
        'password' => 'nullable|between:3,30|confirmed',
        'password_confirmation' => 'same:password',
        'role' => 'required',
        'firstname' => 'required',
        'photo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif|max:1000',
        'cv' => 'sometimes|mimes:docx,doc,pdf|max:2048',
        'lastname' => 'required',
        'othername' => 'sometimes|nullable',
        'birthdate' => 'sometimes|nullable|date',
        'phone' => 'sometimes|nullable|numeric',
        'department' => 'required',
    ];

    public function department(){
        return $this->belongsTo('App\model\Department','dept_id','id');
    }

    public function roles(){
        return $this->belongsTo('App\model\TempRoles','role','id')->withDefault();
    }

    public function salary(){
        return $this->belongsTo('App\model\SalaryStructure','salary_id','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P35);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->get();

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

    public static function searchUser($value){
        return static::join('department', 'department.id', '=', 'temp_users.dept_id')
            ->join('roles', 'roles.id', '=', 'temp_users.role')
            ->where('temp_users.status', '=','1')
            ->where('temp_users.role', '=',Utility::TEMP_EXTERNAL_STAFF)
            ->where(function ($query) use($value){
                $query->where('temp_users.lastname','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.firstname','LIKE','%'.$value.'%') ->orWhere('temp_users.phone','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.address','LIKE','%'.$value.'%')->orWhere('temp_users.qualification','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.email','LIKE','%'.$value.'%')->orWhere('temp_users.discipline','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.experience','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.sex','LIKE','%'.$value.'%')->orWhere('temp_users.active_status','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.nationality','LIKE','%'.$value.'%')->orWhere('temp_users.othername','LIKE','%'.$value.'%')
                    ->orWhere('department.dept_name','LIKE','%'.$value.'%')->orWhere('roles.role_name','LIKE','%'.$value.'%');
            })->get();
    }

    public static function searchEnabledUser($value){
        return static::join('department', 'department.id', '=', 'temp_users.dept_id')
            ->join('roles', 'roles.id', '=', 'temp_users.role')
            ->where('temp_users.active_status', '=','1')
            ->where('temp_users.status', '=','1')
            ->where('temp_users.role', '=',Utility::TEMP_EXTERNAL_STAFF)
            ->where(function ($query) use($value){
                $query->where('temp_users.lastname','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.firstname','LIKE','%'.$value.'%') ->orWhere('temp_users.phone','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.address','LIKE','%'.$value.'%')->orWhere('temp_users.qualification','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.email','LIKE','%'.$value.'%')->orWhere('temp_users.discipline','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.experience','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.sex','LIKE','%'.$value.'%')->orWhere('temp_users.active_status','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.nationality','LIKE','%'.$value.'%')->orWhere('temp_users.othername','LIKE','%'.$value.'%')
                    ->orWhere('department.dept_name','LIKE','%'.$value.'%')->orWhere('roles.role_name','LIKE','%'.$value.'%');
            })->get();
    }

    public static function searchUserDept($value){
        return static::join('department', 'department.id', '=', 'temp_users.dept_id')
            ->join('roles', 'roles.id', '=', 'temp_users.role')
            ->where('temp_users.active_status', '=','1')
            ->where('temp_users.status', '=','1')
            ->where('temp_users.role', '=',Utility::TEMP_EXTERNAL_STAFF)
            ->where('temp_users.dept_id', '=',Auth::user()->dept_id)
            ->where(function ($query) use($value){
                $query->where('temp_users.lastname','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.firstname','LIKE','%'.$value.'%') ->orWhere('temp_users.phone','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.address','LIKE','%'.$value.'%')->orWhere('temp_users.qualification','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.email','LIKE','%'.$value.'%')->orWhere('temp_users.discipline','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.experience','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.sex','LIKE','%'.$value.'%')->orWhere('temp_users.active_status','LIKE','%'.$value.'%')
                    ->orWhere('temp_users.nationality','LIKE','%'.$value.'%')->orWhere('temp_users.othername','LIKE','%'.$value.'%')
                    ->orWhere('department.dept_name','LIKE','%'.$value.'%')->orWhere('roles.role_name','LIKE','%'.$value.'%');
            })->get();
    }

    public static function birthday()
    {

        return static::whereRaw(' DAYOFYEAR(curdate()) <= DAYOFYEAR(dob) AND DAYOFYEAR(curdate()) + 7 >=  dayofyear(dob)')
            ->where('status',Utility::STATUS_ACTIVE)
            ->where('active_status',Utility::STATUS_ACTIVE)
            ->where('dept_id',Utility::checkAuth('temp_user')->dept_id)
            ->orderByRaw('DAYOFYEAR(dob)')
            ->get();

    }

}
