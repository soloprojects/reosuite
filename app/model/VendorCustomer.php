<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class VendorCustomer extends Model
{
    //
    protected  $table = 'vendor_customer';

    private static function table(){
        return 'vendor_customer';
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
        'email1' => 'email',
        'logo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif',
        'name' => 'required',
        'address' => 'required',
        'currency' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id');

    }

    public function currency(){
        return $this->belongsTo('App\model\Currency','currency_id','id');
    }

    public function position(){
        return $this->belongsTo('App\model\Position','position_id','id');
    }

    public function salary(){
        return $this->belongsTo('App\model\SalaryStructure','salary_id','id');
    }

    public function roles(){
        return $this->belongsTo('App\model\Roles','role','id');
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

    public static function countData2($column, $post,$column2, $post2)
    {
        return Utility::countData2(self::table(),$column, $post,$column2, $post2);

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

    public static function searchCustomer($value){
        return static::where('vendor_customer.status', '=','1')
            ->where('vendor_customer.company_type', '=',Utility::CUSTOMER)
            ->where(function ($query) use($value){
                $query->where('vendor_customer.name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.address','LIKE','%'.$value.'%') ->orWhere('vendor_customer.phone','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.contact_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.contact_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.search_key','LIKE','%'.$value.'%')->orWhere('vendor_customer.email1','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.email2','LIKE','%'.$value.'%')->orWhere('vendor_customer.company_no','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.tax_id_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.bank_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.account_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.account_name','LIKE','%'.$value.'%');
            })->get();
    }

    public static function searchVendor($value){
        return static::where('vendor_customer.company_type', '=',Utility::VENDOR)
            ->where('vendor_customer.status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($value){
                $query->where('vendor_customer.name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.address','LIKE','%'.$value.'%') ->orWhere('vendor_customer.phone','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.contact_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.contact_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.search_key','LIKE','%'.$value.'%')->orWhere('vendor_customer.email1','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.email2','LIKE','%'.$value.'%')->orWhere('vendor_customer.company_no','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.tax_id_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.bank_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.account_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.account_name','LIKE','%'.$value.'%');
            })->get();
    }

}
