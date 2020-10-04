<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class CrmOpportunity extends Model
{
    //
    protected  $table = 'crm_opportunity';

    private static function table(){
        return 'crm_opportunity';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'lead' => 'required',
        'opportunity_name' => 'required',
        'opportunity_stage' => 'required',
        'amount' => 'required',
        'closing_date' => 'required',

    ];

    public static $mainRulesCreate = [


    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function salesCycle(){
        return $this->belongsTo('App\model\CrmSalesCycle','sales_cycle_id','id')->withDefault();

    }

    public function lead(){
        return $this->belongsTo('App\model\CrmLead','lead_id','id')->withDefault();

    }

    public function phase(){
        return $this->belongsTo('App\model\CrmStages','stage_id','id')->withDefault();

    }

    public function sales(){
        return $this->belongsTo('App\model\SalesTeam','sales_team_id','id')->withDefault();

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

    public static function getAllDataByYear($year)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereYear('created_at', $year)
            ->orderBy('id','DESC')->get();

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

    public static function searchOpportunity($column, $post)
    {
        return static::where($column,'LIKE','%'.$post.'%')->orderBy('id','DESC')->get();

    }

    public static function massDataDate3($column, $post, $dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->whereBetween('created_at',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function massDataDate4($column, $post, $column2, $post2,$dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2,$post2)->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate($dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function searchData($value){
        return static::join('crm_stages', 'crm_stages.id', '=', 'crm_opportunity.stage_id')
            ->join('crm_lead', 'crm_lead.id', '=', 'crm_opportunity.lead_id')
            ->join('crm_sales_team', 'crm_sales_team.id', '=', 'crm_opportunity.sales_team_id')
            ->where('crm_opportunity.status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($value){
                $query->where('crm_opportunity.opportunity_name','LIKE','%'.$value.'%')->orWhere('crm_lead.name','LIKE','%'.$value.'%')
                    ->orWhere('crm_lead.contact_name','LIKE','%'.$value.'%')
                    ->orWhere('crm_stages.name','LIKE','%'.$value.'%')->orWhere('crm_sales_team.name','LIKE','%'.$value.'%');
            })->get();
    }

}
