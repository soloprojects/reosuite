<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 11/10/2017
 * Time: 2:05 PM
 */

namespace App\Helpers;

use App\model\AccountStatus;
use App\model\InventoryBom;
use App\model\QuickNote;
use App\model\Vehicle;
use App\model\AccountChart;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use view;
use mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\Currency;
use Illuminate\Support\Facades\Session;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class Utility
{

    const DEFAULT_LOGO = 'logo.jpg';
    const STATUS_INACTIVE = 2, STATUS_ACTIVE = 1, STATUS_DELETED = 0;
    const USER_ROLES_ARRAY = [2,3,4,5,6,7,8,9,10];
    const EXTERNAL_CONTRACT_STAFF_ROLE = 2;
    const PROCESSING = 0, APPROVED = 1, DENIED = 2, COMPLETED = 1;
    const USUAL_REQUEST_TYPE = 1, PROJECT_REQUEST_TYPE = 2;
    const TOP_USERS = [1,2,3], ACCOUNTANTS = 5, HR_MANAGEMENT = [1,2,3,6], ACCOUNT_MANAGEMENT = [1,2,3,5],
        HR = 6, SCM_MANAGEMENT = [1,2,3,9], ACCOUNT_SCM_WHSE_MANAGEMENT = [1,2,3,5,9,10], ADMIN = 3,
        ACCOUNT_SCM_WHSE_ADMIN = [1,3,5,9,10], ACCOUNT_HR_MANPOWER_MANAGEMENT = [1,2,3,5,6,7],
        ACCOUNT_HR_MANAGEMENT = [1,2,3,5,6], MANPOWER = 7, CONTROLLER = 1;
    const PRO_QUAL = 1, TECH_COMP = 2, BEHAV_COMP = 3;
    const APP_OBJ_GOAL = 1, COMP_ASSESS = 2, BEHAV_COMP2 = 3, INDI_REV_COMMENT = 4, EMP_COM_APP_PLAT = 5;
    const P25 = '25', P20 = '20', P15 = '15', P50 = '50', P100 = '100', P35 = '35';
    const HOD_DETECTOR = 1, DETECT = 1;
    const REVIEW_RATE = [1 => 'None', 2 => 'Exceeded Expectations', 3 => 'Met expectations', 4 => 'Did not meet expectations'];
    const REVIEW_COMP = [1 => 'None', 2 => '5', 3 => '4', 4 => '3', 5 => '2', 6 => '1'];
    const REVIEW_RATE2 = [1,2,3,4,5,'Nil'];
    const REVIEW_LEVEL = [1,2,3,4,5,'Nil'];
    const OVERALL_RATING = [1 => 'None', 2 => 'O - Outstanding', 3 => 'H - High performer', 4 => 'P - Performing as expected',
                            5 => 'B - Below expectations'];
    const ZERO = 0;
    const SIGN_OFF =[1=>'Appraisal Ongoing', 2 => 'Sign off'];
    const APPRAISAL_STATUS = [0 => 'Reviewing Phase', 1 => 'Appraisal Completed'];
    const SALARY_ADVANCE_ID = 2, EMPLOYEE_LOAN_ID = 3;
    const DEFAULT_REQUEST_CATEGORIES = [self::SALARY_ADVANCE_ID,self::EMPLOYEE_LOAN_ID];
    const LOAN_REQUEST = 1, SALARY_ADVANCE_REQUEST = 2;
    const PAYROLL_BONUS = 1, PAYROLL_DEDUCTION = 2;
    const PAY_INTERVAL = [1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',
        7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November', 12 => 'December'];

    const COMPONENT_TYPE = [1 => 'Earnings',2 => 'Deduction'];
    const TRAINING_TYPE = [1 => 'Internal',2 => 'External'];

    const SPECIAL_EQUIP = ['According to bin','According to SKU/Item'];
    const CAPACITY_POLICY = ['Never check capacity','Allow more than max capacity','Prohibit more than max capacity'];

    const VENDOR = 1, CUSTOMER = 2, EMPLOYEE = 3;
    const COST_METHOD = ['FIFO','LIFO','Specific','Average','Standard'];
    const INVENTORY_TYPE = [1 => 'Inventory', 2 => 'Non-Inventory', 3 => 'Service'];
    const INVENTORY_ITEM = 1, NON_INVENTORY_ITEM = 2, SERVICES_ITEM = 3;
    const DEFAULT_ACCOUNT_CHART = [1,7];
    const NO_DEPRECIATION_ACCOUNT_CAT_DB_ID = [1,2,3,5,6,7,8,9,5], FIXED_ASSET_DB_ID = 4; //THESE ACCOUNT CATEGORIES BELONGS TO BALANCE SHEET ACCOUNTS
    const BALANCE_SHEET_ACCOUNTS = [1,2,3,4,5,6,7,8,9,10];
    
    const DEFAULT_BANK_ID_ACCOUNT_CHART = 7, BANK_ACCT_CAT_ID = 3, BANK_DETAIL_ID =17;
    const CREDIT_TABLE_ID = 1, DEBIT_TABLE_ID = 2;

    //CREDIT_OPENING_BALANCE_EQUITY ARE "DEBIT ACCOUNTS"    DEBIT_OPENING_BALANCE_EQUITY ARE "CREDIT ACCOUNTS" SO THAT YOU DON'T GET CONFUSED ABOUT IT
    const CREDIT_OPENING_BALANCE_EQUITY = [1,3,4,2,5], DEBIT_OPENING_BALANCE_EQUITY = [6,7,8,9], OPENING_BALANCE_EQUITY_CHART_ID = 1, OPENING_BALANCE_DETAIL_ID = 51,
            OPENING_BALANCE_ACCOUNT_CATEGORY_ID =10, CREDIT_CARD_CATEGORY_ID = 7;

    const CREDIT_ACCOUNTS = [6,7,8,9,10,11,12], DEBIT_ACCOUNTS = [1,3,4,2,5,13,14,15];

    const LINE_ITEM_DISCOUNT = 1, ONE_TIME_DISCOUNT = 2;
    const LINE_ITEM_TAX = 1, ONE_TIME_TAX = 2;
    const SHIP_STATUS = [1 => 'PO sent to supplier', 2 => 'Actioned payment to supplier',
        3 => 'Item Delivered to designated forwarder', 4 => 'Delivered to port', 5 =>'Custom clearing',
        6 => 'Item Delivered to Client', 7 => 'Invoice Submitted to client', 8 => 'Po Closed'];

    const QUOTE_STATUS = [1 => 'Invoice Submitted to client', 2 => 'PO sent to supplier',
        3 => 'Received Payment from Customer', 4 => 'Actioned payment to supplier',
        5 => 'Item Delivered to Client', 6 => 'Quote Closed'];
    const TICKET_STATUS = [0 => 'Open', 1 => 'Closed'];

    const SALES_DESC = 2, PURCHASE_DESC = 1;    //FOR PO,RFQ,QUOTES,EXPENSES AND OTHER TRANSACTIONS
    const POST_RECEIPT = 1, CREATE_RECEIPT = 2; //FOR WAREHOUSE RECEIPT
    const POST_SHIPMENT = 1, CREATE_SHIPMENT = 2; //FOR WAREHOUSE SHIPMENT
    const PUT_AWAY = 1, PICK = 2;
    const ALL_DATA = 0, SELECTED = 1;   //FOR REPORT MoDULE IN MOST OF THE MODULES
    const TASK_STATUS = ['Not Started','In Progress','On Hold','Completed','Cancelled','Waiting'];
    const TASK_PRIORITY = ['None','Low','Medium','High'];   //FOR PROJECT TASK MDULE
    const T_USER = '2', P_USER = '1';
    const TEMP_EXTERNAL_STAFF = 2, TEMP_JOB_CANDIDATE = 1, TEMP_CLIENT = 3;
    const HSE_REPORT_TYPE = [1 => 'Incident', 2 => 'Hazard'];   //FOR HSE MDULE
    const EVENT_TYPE = [1 => 'My Schedule', 2 => 'General Schedule'];   //FOR EVENT MODULE
    const GENERAL_SCHEDULE = 2, MY_SCHEDULE = 1;    //FOR EVENT MODULE
    const ONGOING = 1, WON = 2, LOST = 3; //FOR CRM MODULE
    const READY_FOR_APPROVAL = 1, NOT_READY_FOR_APPROVAL = 2; //FOR BUDGET MODULE

    const REQUEST_CATEGORY_DIMENSION = 1, ACCOUNT_CHART_DIMENSION = 2;
    const OPEN_ACCOUNT_STATUS = 1, CLOSED_ACCOUNT_STATUS = 2;
    const MAIN_TRANSACTION = 1;

    public static function IMG_URL($image = ''){
        return public_path() . '/images/'.$image;
    }

    public static function FILE_URL($file = ''){
        return public_path() . '/files/'.$file;
    }

    public static function AUDIO_URL(){
        return public_path() . '/audio/';
    }

    public static function generateUniqueId($table = null, $column, $limit = 12) {
        $uid = "";
        $array = array_merge(range(0, 1), range(7, 9));
        for ($i = 0; $i < $limit; $i++) {
            $uid.=$array[array_rand($array)];
        }
        if($table === null){
            return $uid;
        }
        else{
            if(self::uniqueIdExists($column, $uid , $table)){
                $uid =  self::generateUniqueId($table , $column, $limit);
            }
            return $uid;

        }

    }

    public static function generateUID($table = null, $limit = 12) {
        $uid = "";
        $array = array_merge(range(0, 1), range(7, 9));
        for ($i = 0; $i < $limit; $i++) {
            $uid.=$array[array_rand($array)];
        }
        if($table === null){
            return $uid;
        }
        else{
            if(self::uidExists($uid , $table)){
                $uid =  self::generateUID($table , $limit);
            }
            return $uid;

        }

    }

    public static function generateEID($table = null, $limit = 6,$prefix) {
        $uid = "";
        $array = array_merge(range(0, 1), range(7, 9));
        for ($i = 0; $i < $limit; $i++) {
            $uid.=$prefix.'-'.$array[array_rand($array)];
        }
        if($table === null){
            return $uid;
        }
        else{
            if(self::eidExists($uid , $table)){
                $uid =  self::generateEID($table , $limit);
            }
            return $uid;

        }

    }

    public static function digitalSign($table = null, $column = null, $limit = 18) {
        $uid = "hyp-";
        $array = array_merge(range(1, 20), range(20, 40));
        for ($i = 0; $i < $limit; $i++) {
            $uid.=$array[array_rand($array)];
        }
        if($table === null){
            return $uid;
        }
        else{
            if(self::digitalSignExists($uid , $column, $table)){
                $uid =  self::digitalSign($table , $column, $limit);
            }
            return $uid;

        }

    }

    public static function genRememberToken($table = null, $limit = 12) {
        $token = "";
        $array = array_merge(range(0, 1), range(7, 9));
        for ($i = 0; $i < $limit; $i++) {
            $token.=$array[array_rand($array)];
        }
        $token.= time();
        if($table === null){
            return md5($token);
        }
        else{
            if(self::tokenExists($token , $table)){
                $token =  self::genRememberToken($table , $limit);
            }
            return md5($token);

        }

    }

    public static function uniqueIdExists($column,$uid, $table){
        $exists =  DB::table($table)->where($column , $uid)->count();
        return $exists > 0 ? true : false;
    }

    public static function uidExists($uid, $table){
        $exists =  DB::table($table)->where('uid' , $uid)->count();
        return $exists > 0 ? true : false;
    }

    public static function eidExists($uid, $table){
        $exists =  DB::table($table)->where('uid' , $uid)->count();
        return $exists > 0 ? true : false;
    }

    public static function digitalSignExists($uid, $column, $table){
        $exists =  DB::table($table)->where($column , $uid)->count();
        return $exists > 0 ? true : false;
    }

    public static function tokenExists($token, $table){
        $exists =  DB::table($table)->where('remember_token' , $token)->count();
        return $exists > 0 ? true : false;
    }

    public static function itemExists($item, $table,$column){
        $exists =  DB::table($table)->where($column , $item)->where('status' , self::STATUS_ACTIVE)->count();
        if($exists){
            return true;
        }
        else{
            return false;
        }
        //return $exists > 0 ? true : false;
    }

    public static function convertDate(&$date){

        return date("d M Y H:i:s", strtotime($date));
    }

    public static function formatDateFields(&$data){
        foreach($data as &$val){
            //$val->formatted_date = self::convertDate($val->created_at);
            $val->formatted_date = date('d M Y', strtotime($val->created_at));
        }
        return $data;
    }

    public static function humanTiming ($time)
    {

        $time = time() - intval($time); // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }

    public static function realDateInterval(&$dataObject){

        foreach($dataObject as &$value){

            $old_date = $value->created_at;
            $time = strtotime($old_date);
            $diff = self::humanTiming($time).' ago';
            //$diff = self::humanTiming($time);
            $value->time_past = $diff;
            //$value->time_past = $value->created_at->diffForHumans();
        }
        return $dataObject;

    }

    public static function publicHumanTiming($value){

        $old_date = $value;
        $time = strtotime($old_date);
        $diff = self::humanTiming($time).' ago';
        //$diff = self::humanTiming($time);
        return  $diff;
        //return $value->diffForHumans();

    }

    public static function assembleArray(&$array){
        $default = [];
        foreach($array as $item){
            $default[] = $item;
        }
        return $default;
    }

    public static function arrayDiff($localArray,$foreignArray){
        $default = [];
        foreach($localArray as $item){
            $default[] = $item->id;
        }
        $newArray = array_diff($default,$foreignArray);
        return $newArray;
    }

    public static function firstRow($table,$column,$post)
    {
        return DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->where($column, $post)
            ->orderBy('id','DESC')->first();

    }

    public static function firstRow2($table,$column,$post,$column2,$post2)
    {
        return DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->where($column, $post)
            ->where($column2, $post2)
            ->orderBy('id','DESC')->first();

    }

    public static function paginateAllData($table)
    {
        return DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate('15');

    }

    public static function specialColumns3($table,$column, $post, $column2, $post2, $column3, $post3)
    {

        return DB::table($table)
            ->where('status', '=',self::STATUS_ACTIVE)
            ->where($column, '=',$post)
            ->where($column2, '=',$post2)
            ->where($column3, '=',$post3)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumns5($table,$column, $post, $column2, $post2, $column3, $post3, $column4, $post4, $column5, $post5)
    {

        return DB::table($table)
            ->where('status', '=',self::STATUS_ACTIVE)
            ->where($column, '=',$post)
            ->where($column2, '=',$post2)
            ->where($column3, '=',$post3)
            ->where($column4, '=',$post4)
            ->where($column5, '=',$post5)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumns6($table,$column, $post, $column2, $post2, $column3, $post3, $column4, $post4, $column5, $post5, $column6, $post6)
    {

        return DB::table($table)
            ->where('status', '=',self::STATUS_ACTIVE)
            ->where($column, '=',$post)
            ->where($column2, '=',$post2)
            ->where($column3, '=',$post3)
            ->where($column4, '=',$post4)
            ->where($column5, '=',$post5)
            ->where($column6, '=',$post6)
            ->orderBy('id','DESC')->get();

    }

    public static function sumColumnDataCondition($table,$column, $post,$sumColumn)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->sum($sumColumn);

    }

    public static function sumColumnDataCondition2($table,$column, $post,$column2, $post2,$sumColumn)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)
            ->sum($sumColumn);

    }

    public static function sumColumnDataCondition3($table,$column, $post,$column2, $post2,$column3, $post3,$sumColumn)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where('status', self::STATUS_ACTIVE)
            ->sum($sumColumn);

    }

    public static function countData($table,$column, $post)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function countDataOr3($table,$column1, $post1,$column2, $post2, $column3, $post3)
    {
        return DB::table($table)
            ->where($column1, $post1)
            ->where($column2, $post2)
            ->orWhere($column3, $post3)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function countData2($table,$column1, $post1,$column2, $post2)
    {
        return DB::table($table)
            ->where($column1, $post1)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function countData3($table,$column1, $post1,$column2, $post2,$column3, $post3)
    {
        return DB::table($table)
            ->where($column1, $post1)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function countData4($table,$column1, $post1,$column2, $post2,$column3, $post3,$column4, $post4)
    {
        return DB::table($table)
            ->where($column1, $post1)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where($column4, $post4)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function massData($table,$column, $post)
    {
        return DB::table($table)
            ->whereIn($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();

    }
    public static function massDataCondition($table,$column, $post, $column2, $post2)
    {
        return DB::table($table)
            ->whereIn($column, $post)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();

    }

    public static function deleteItem($table,$postId)
    {
        return DB::table($table)
            ->where('id' , $postId
            )->delete();

    }

    public static function deleteItemData($table,$id,$postId)
    {
        return DB::table($table)
            ->where($id , $postId
            )->delete();

    }

    public static function massUpdate($table,$column, $arrayPost, $arrayDataUpdate=[])
    {
        return DB::table($table)
            ->whereIn($column , $arrayPost
            )->update($arrayDataUpdate);

    }

    public static function defaultUpdate($table,$column, $postId, $arrayDataUpdate=[])
    {
        return DB::table($table)
            ->where($column , $postId
            )->update($arrayDataUpdate);

    }

    public static function tenColumnSingleValue($table,$column1,$column2,$column3,$column4
        ,$column5,$column6,$column7,$column8,$column9,$column10, $post)
    {
            return DB::table($table)
                ->where($column1, $post)
                ->orWhere($column2, $post)
                ->orWhere($column3, $post)
                ->orWhere($column4, $post)
                ->orWhere($column5, $post)
                ->orWhere($column6, $post)
                ->orWhere($column7, $post)
                ->orWhere($column8, $post)
                ->orWhere($column9, $post)
                ->orWhere($column10, $post)
                ->where('status', self::STATUS_ACTIVE)->get();

    }

    public static function detectHOD($id)
    {
        $data = DB::table('dept_approvals')
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                if ($value->dept_head == $id) {
                    $determiner = 1;
                }
            }
        }
        return $determiner;
    }

    public static function detectHODId($deptId)
    {
        $data = DB::table('dept_approvals')
            ->where('dept', $deptId)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                    $determiner = $value->dept_head;
            }
        }
        return $determiner;
    }

    public static function appSupervisor($table,$dept,$id)
    {
        $data = DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                if ($value->user_id == $id) {
                    $determiner = 1;
                }
            }
        }
        return $determiner;
    }

    public static function appSupervisorId($table,$dept,$id)
    {
        $data = DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->where('dept_id', $dept)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                    $determiner = 1;
            }
        }
        return $determiner;
    }

    public static function detectSelected($table,$id)
    {
        $data = DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                if ($value->user_id == $id) {
                    $determiner = 1;
                }
            }
        }
        return $determiner;
    }

    public static function detectRequestAccess($data){
            $detect = 0;
            foreach($data as $val){
                if($val->user_id == Auth::user()->id){
                    $detect = 1;
                }
            }
            return $detect;
    }

    public static function getDaysLength($startDate,$endDate){
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        if($startDate <= $endDate){
            $datediff = $endDate - $startDate;
            //return floor($datediff / (60 * 60 * 24));
            $count = 0;

            /*while(date('Y-m-d', $startDate) < date('Y-m-d', $endDate)){
                $count += date('N', $startDate) < 6 ? 1 : 0;
                $startDate = strtotime("+1 day", $startDate);
            }*/

            //WORKING DAYS
            for($i=$startDate; $i<=$endDate; $i = $i+(60*60*24) ){
                if(date("N",$i) <= 5) $count = $count+ 1;
            }

            return $count;


        }
        return 0;
    }

    public static function LeaveDaysValidator($leaveType,$days)
    {
        $year = date('Y');
        $determiner = false;
        $leave = DB::table('leave_type')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $leaveType)->first();

        $data = DB::table('leave_log')
            ->where('status', self::STATUS_ACTIVE)
            ->where('leave_type', $leave->id)
            ->where('request_user', Auth::user()->id)
            ->where('deny_reason', '')
            ->where('approval_status', self::APPROVED)
            ->where('year', $year)->sum('duration');

        $dayLength = $data + $days;
        $determiner = ($leave->days >= $dayLength) ? true : false;

        return $determiner;
    }

    public static function dateTimeDiff($dateTime1,$dateTime2){
        // Declare and define two dates
        $date1 = strtotime($dateTime1);
        $date2 = strtotime($dateTime2);

        // Formulate the Difference between two dates
                $diff = abs($date2 - $date1);


        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
                $years = floor($diff / (365*60*60*24));


        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
                $months = floor(($diff - $years * 365*60*60*24)
                    / (30*60*60*24));


        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
                $days = floor(($diff - $years * 365*60*60*24 -
                        $months*30*60*60*24)/ (60*60*24));


        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
                $hours = floor(($diff - $years * 365*60*60*24
                        - $months*30*60*60*24 - $days*60*60*24)
                    / (60*60));


        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
                $minutes = floor(($diff - $years * 365*60*60*24
                        - $months*30*60*60*24 - $days*60*60*24
                        - $hours*60*60)/ 60);


        // To get the minutes, subtract it with years,
        // months, seconds, hours and minutes
                $seconds = floor(($diff - $years * 365*60*60*24
                    - $months*30*60*60*24 - $days*60*60*24
                    - $hours*60*60 - $minutes*60));

        $result = $years.' years, '.$months.' months, '.$days.' days, '.$hours.' hours, '.$minutes.' minutes, '.$seconds.' seconds';

        return $result;

    }

    public static function standardDate($date){
        if($date != ''){
            $newDate = date("Y-m-d", strtotime($date));
            return $newDate;
        }
        return $date;

    }

    public static function standardDateTime($date){
        $newDate = date("Y-m-d H:i:s", strtotime($date));
        return $newDate;
    }

    public static function addDaysToPostDate($days,$dateParam){
        return self::standardDate($dateParam. ' + '.$days.' days');
    }

    public static function termsToDueDate($termId,$postDate){
        $termsData = DB::table('journal_transaction_terms')
        ->where('status', self::STATUS_ACTIVE)
        ->where('id', $termId)->first();
        
        $days = $termsData->days_due;
        $dueDate = self::addDaysToPostDate($days,$postDate);
        return $dueDate;

    }

    public static function extraLeaveDays($leaveTypeParam){
        $year = date('Y');
        $determiner = 0;
        $leaveType = DB::table('leave_type')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $leaveTypeParam)->first();

        $data = DB::table('leave_log')
            ->where('status', self::STATUS_ACTIVE)
            ->where('leave_type', $leaveTypeParam)
            ->where('request_user', Auth::user()->id)
            ->where('deny_reason', '')
            ->where('year', $year)->sum('duration');

        $determiner = $leaveType->days - $data;

        return $determiner;
    }

    public static function loanMonthlyDeduction($amount,$interestRATE){

        $data = DB::table('loan')
            ->where('status', self::STATUS_ACTIVE)
            ->where('loan_status', self::STATUS_ACTIVE)->first();

        $interestAmount = $amount*($interestRATE/100);
        $totalPayBackAmount = $amount+$interestAmount;
        $monthPayBackAmount = $totalPayBackAmount/$data->duration;
        return $monthPayBackAmount;
    }

    public static function calculateSalary($userId,$extraAmount,$bonusDeduc){

        $data = DB::table('users')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $userId)->first();

        $salaryData = DB::table('salary')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $data->salary_id)->first();


        $newAmount = 0;

        if($bonusDeduc == '0') {
            $newAmount = $salaryData->net_pay;
        }else{

            $salAdvData = DB::table('requisition')
                ->where('request_user', $userId)
                ->where('req_cat', self::SALARY_ADVANCE_ID)
                ->where('accessible_status', self::STATUS_ACTIVE)
                ->where('status', self::STATUS_ACTIVE)->get();

            $loanData = DB::table('requisition')
                ->where('request_user', $userId)
                ->where('req_cat', self::EMPLOYEE_LOAN_ID)
                ->where('accessible_status', self::STATUS_ACTIVE)
                ->where('loan_balance', '>', '0')
                ->where('status', self::STATUS_ACTIVE)->get();

            $loan = 0;
            $salAdv = 0;
            $dbDataSalAdv = ['accessible_status' => self::ZERO];
            Log::info($salAdv.'loan='.$loan.'user='.$userId);
            if (count($loanData) > 0 || count($salAdvData) > 0) {

                if (count($loanData) > 0) {
                    $loan = $loanData[0]->loan_monthly_deduc;
                    //self::defaultUpdate('requisition','id',$loanData[0]->id,$dbData);
                }
                if (count($salAdvData) > 0) {
                    $salAdv = $salAdvData[0]->amount;
                    self::defaultUpdate('requisition','id',$salAdvData[0]->id,$dbDataSalAdv);
                }
               
                $extraDeduc = $salAdv + $loan;
                $salaryDeduc = $salaryData->net_pay - $extraDeduc;
                $newAmount = ($bonusDeduc == self::PAYROLL_BONUS) ? $salaryDeduc + $extraAmount : $salaryDeduc - $extraAmount;

            } else {
                $newAmount = ($bonusDeduc == self::PAYROLL_BONUS) ? $salaryData->net_pay + $extraAmount : $salaryData->net_pay - $extraAmount;

            }


        }


        return $newAmount;
    }

    public static function calculateSalaryWithoutLoanSalAdv($userId,$extraAmount,$bonusDeduc){

        $data = DB::table('users')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $userId)->first();

        $salaryData = DB::table('salary')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $data->salary_id)->first();


        $newAmount = 0;

        if($bonusDeduc == '0') {
            $newAmount = $salaryData->net_pay;
        }else{

                $newAmount = ($bonusDeduc == self::PAYROLL_BONUS) ? $salaryData->net_pay + $extraAmount : $salaryData->net_pay - $extraAmount;

        }


        return $newAmount;
    }

    public static function calculateSalaryWithoutLoanSalAdvExternal($userId,$extraAmount,$bonusDeduc){

        $data = DB::table('temp_users')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $userId)->first();

        $salaryData = DB::table('salary')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $data->salary_id)->first();


        $newAmount = 0;

        if($bonusDeduc == '0') {
            $newAmount = $salaryData->net_pay;
        }else{

                $newAmount = ($bonusDeduc == self::PAYROLL_BONUS) ? $salaryData->net_pay + $extraAmount : $salaryData->net_pay - $extraAmount;

        }


        return $newAmount;
    }

    public static function userLoanTotal($userId){
        //ONLY ONE ACTIVE LOAN CAN EXIST IN THE SYSTEM FROM A USER
        $loanData = DB::table('requisition')
            ->where('request_user', $userId)
            ->where('req_cat', self::EMPLOYEE_LOAN_ID)
            ->where('accessible_status', self::STATUS_ACTIVE)
            ->where('loan_balance', '>', '0')
            ->where('status', self::STATUS_ACTIVE)->sum('loan_monthly_deduc');
        $total = ($loanData > 0) ? $loanData : 0.00;
        return $total;
    }

    //ONLY ONE ACTIVE SALARY ADVANCE CAN EXIST IN THE SYSTEM FROM A USER
    public static function userSalAdvTotal($userId){
        $salAdvData = DB::table('requisition')
            ->where('request_user', $userId)
            ->where('req_cat', self::SALARY_ADVANCE_ID)
            ->where('accessible_status', self::STATUS_ACTIVE)
            ->where('status', self::STATUS_ACTIVE)->sum('amount');

        $total = ($salAdvData > 0) ? $salAdvData : 0.00;
        return $total;

    }

    public static function convertIntToMonth($int){

    }

    public static function getMonthFromDate($date){
        return date('n', strtotime( $date ));

    }

    public static function checkForDeductions($userId,$month,$bonusDeduc){

        $deductData = DB::table('requisition')
            ->where('request_user', $userId)
            ->where('req_cat', self::EMPLOYEE_LOAN_ID)
            ->orWhere('req_cat', self::SALARY_ADVANCE_ID)
            ->where('hr_accessible', self::COMPLETED)
            ->where('status', self::STATUS_ACTIVE)->get();

        $deductLoan = 0;
        $deductSalAdv = 0;
        $deduct = 0;
        if (count($deductData) > 0) {
            foreach($deductData as $data){
                $getMonth = self::getMonthFromDate($data->approval_date);
                if($data->req_cat = self::EMPLOYEE_LOAN_ID){
                    if($getMonth == $month  && $data->approval_status == self::APPROVED){
                        $deductLoan = $data->loan_monthly_deduc;
                    }
                }
                if($data->req_cat = self::SALARY_ADVANCE_ID){
                    if($getMonth == $month && $data->approval_status == self::APPROVED){
                        $deductSalAdv = $data->amount;
                    }
                }

            }
            $deduct = ($bonusDeduc == self::EMPLOYEE_LOAN_ID) ? $deductLoan : $deductSalAdv;

        }
        return $deduct;

    }

    public static function companyInfo(){

        $data = DB::table('company_info')
            ->where('status', self::STATUS_ACTIVE)
            ->where('active_status', self::STATUS_ACTIVE)->first();

        if(empty($data)){
            $emptyData = new \stdClass();
            $emptyData->name = 'Name of organisation';
            $emptyData->address = 'Enter address';
            $emptyData->email = 'Enter Email';
            $emptyData->phone1 = 'Enter phone 1';
            $emptyData->phone2 = 'Enter phone 2';
            $emptyData->active_status = 'No active status';

            return $emptyData;
        }

        return $data;

    }

    public static function odometerMeasure(){

        $data = DB::table('vehicle_odometer_measure')
            ->where('status', self::STATUS_ACTIVE)
            ->where('active_status', self::STATUS_ACTIVE)->first();

        if(empty($data)){
            $emptyData = new \stdClass();
            $emptyData->name = 'Miles';
            $emptyData->status = '0';

            return $emptyData;
        }

        return $data;

    }

    public static function convertAmount($currCurrencyCode,$newCurrencyCode,$amount){
        $defaultCurrStatus = self::firstRow2('currency','default_curr_status',self::STATUS_ACTIVE,'code',$newCurrencyCode);
        if(!empty($defaultCurrStatus)){
            $defaultCurr = (!empty($defaultCurrStatus)) ? $defaultCurrStatus->default_currency : 0.00;
            $converted = ($currCurrencyCode == $newCurrencyCode) ? $amount : $amount/$defaultCurr;
            return self::roundNum($converted,2);
        }
        $curr = 'USD'.$currCurrencyCode;
        $data = DB::table('exchange_rate')
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->first();

        $rates = json_decode($data->rates,true);
        $currRate = $rates['quotes'][$curr];
        
        $dollarAmt = $amount/$currRate;
        $new = 'USD'.$newCurrencyCode;
        $newRate = $rates['quotes'][$new];
        $converted = $dollarAmt*$newRate;
        return self::roundNum($converted,2);
    }

    public static function convertAmountToDate($currCurrencyCode,$newCurrencyCode,$amount,$postDate){

        $defaultCurrStatus = self::firstRow2('currency','default_curr_status',self::STATUS_ACTIVE,'code',$newCurrencyCode);
        if(!empty($defaultCurrStatus)){
            $defaultCurr = $defaultCurrStatus->default_currency;
            $converted = ($currCurrencyCode == $newCurrencyCode) ? $amount : $amount/$defaultCurr;
            return self::roundNum($converted,2);
        }
        $dateRates = self::ratesBasedOnDate($postDate);

        $curr = 'USD'.$currCurrencyCode;
        $rates = json_decode($dateRates,true);
        $currRate = $rates['quotes'][$curr];
        $dollarAmt = $amount/$currRate;
        $new = 'USD'.$newCurrencyCode;
        $newRate = $rates['quotes'][$new];
        $converted = $dollarAmt*$newRate;
        
        return self::roundNum($converted,2);        

    }

    public static function chartBalance($accCat,$debit,$credit){
        
        $value = '0.00';
        if(in_array($accCat,self::DEBIT_ACCOUNTS)){

            $result = $debit - $credit;
            $value = self::roundNum($result,2);
        }
        if(in_array($accCat,self::CREDIT_ACCOUNTS)){
            $result = $credit - $debit;
            $value =  self::roundNum($result,2);
        }
        return $value;

    }

    //THE CURRENT ACCOUNT TYPE TO RETURN FOR TRANSACTION DEPENDING ON THE ACCOUNT CATEGORY, EITHER DEBIT OR CREDIT
    public static function openingBalanceCreditDebit($accountCategoryId){
        $transaction = 0;
        if(in_array($accountCategoryId,self::CREDIT_OPENING_BALANCE_EQUITY)){
            $transaction = self::DEBIT_TABLE_ID;    //RETURN DEBIT TO THIS ACCOUNT CATEGORY AND CREDIT OPENING BALANCE EQUITY
        }
        if(in_array($accountCategoryId,self::DEBIT_OPENING_BALANCE_EQUITY)){
            $transaction = self::CREDIT_TABLE_ID;   //RETURN  $data = self::firstRow('closing_books','active_status',self::STATUS_ACTIVE);CREDIT TO THIS ACCOUNT CATEGORY AND DEBIT OPENING BALANCE EQUITY
        }
        return $transaction;

    }

    public static function detectClosingBookStatus(){
        $data = self::firstRow('closing_books','active_status',self::STATUS_ACTIVE);
        $detect = 0;
        if(!empty($data)){
            $detect = 1;
        }
        return $detect;
    }

    public static function checkClosingBook($transactionDate,$password){
        $detect = 0;
        if(empty($transactionDate)){
            $detect = 1;
            return $detect;
        }
        $closing = self::firstRow('closing_books','active_status',self::STATUS_ACTIVE);
        if(!empty($closing)){
            if(self::standardDate($closing->closing_date) >= $transactionDate){
                
                if($closing->password == md5($password)){
                    $detect = 1;
                }else{
                    $detect = 0;
                }
            }else{
                $detect = 1;
            }
        }else{
            $detect = 1;
        }
        return $detect;


    }

    public static function checkCurrencyActiveStatus(){
        $data = self::firstRow('currency','active_status',self::STATUS_ACTIVE);
        if(empty($data)){
            exit(json_encode([
                'message2' => 'Please, navigate to the configuration to activate system default currency',
                'message' => 'currency inactive'
            ]));
        }
    }

    public static function checkDefaultAccountChartCurrency($chart_id){
        $data = self::firstRow('account_chart','id',$chart_id);
        $currency = $data->curr_id;
        if($data->curr_id == ''){
            $currency = self::currencyArrayItem('id');
        }
        return $currency;
    }

    public static function checkFinYearActiveStatus(){
        $checkFinYear = self::firstRow('financial_year','active_status',self::STATUS_ACTIVE);
        if(empty($checkFinYear)){
            exit(json_encode([
                'message2' => 'Please,create and activate a financial year to continue this process',
                'message' => 'warning'
            ]));
        }
    }

    public static function checkExistingLedgerTrans(){
        $checkLedgerTrans = DB::table('account_journal')
            ->where('debit_credit', self::DEBIT_TABLE_ID)
            ->orWhere('debit_credit', self::CREDIT_TABLE_ID)
            ->where('status', self::STATUS_ACTIVE)->first();

        if(!empty($checkLedgerTrans)) {
            exit(json_encode([
                'message2' => 'Currency cannot be changed, the general ledger already has existing transaction linked to this data',
                'message' => 'rejected'
            ]));
        }
    }

    public static function checkVendorCustomerExistingLedgerTrans($id,$currencyId){
        $getData = DB::table('vendor_customer')->where('id', $id)
            ->where('status', self::STATUS_ACTIVE)->first();

        $checkLedgerTrans = DB::table('account_journal')
            ->where('vendor_customer', $id)
            ->where('debit_credit', self::DEBIT_TABLE_ID)
            ->orWhere('debit_credit', self::CREDIT_TABLE_ID)
            ->where('status', self::STATUS_ACTIVE)->first();

        if(!empty($checkLedgerTrans) && $getData->currency_id != $currencyId) {
            exit(json_encode([
                'message2' => 'Currency cannot be changed, the general ledger already has existing transaction linked to this data',
                'message' => 'rejected'
            ]));
        }
    }

    public static function currencyArrayItem($arrayItem){
        if(session('currency')){
            return session('currency')[$arrayItem];
        }else{
            return 'None';
        }
    }

    public static function defaultCurrency(){
        if(session('currency')){
            return '('.session('currency')['code'].')'.session('currency')['symbol'];
        }else{
            return '';
        }
    }

    public static function checkArraySimilarity($childArray,$houseArray){
        $detect = false;
        foreach($houseArray as $house){
            foreach($childArray as $child){
                if($house == $child){
                   $detect = true;
                }
            }
        }
        return $detect;
    }

    public static function currencyExists($currencyDate){
        $exRate = '';
        $data =  DB::table('exchange_rate')->whereDate('created_at', self::standardDate($currencyDate))->first();
        return empty($data) ? true : false;
    }

    public static function ratesBasedOnDate($currencyDate) {
        $uid = "";
        $data =  DB::table('exchange_rate')->whereDate('created_at', self::standardDate($currencyDate))->orderBy('id','DESC')->first();
        if(!empty($data)){
            return $data->rates;
        }
        else{

            $newDate = date("Y-m-d");

            $data = DB::table('exchange_rate')
                ->where('status', self::STATUS_ACTIVE)
                ->orderBy('id','DESC')->first();

            return $data->rates;

        }

    }

    public static function ratesBasedOnDateData($currencyDate) {
        $uid = "";
        $data =  DB::table('exchange_rate')->whereDate('created_at', self::standardDate($currencyDate))->orderBy('id','DESC')->first();
        if(!empty($data)){
            return $data->rates;
        }
        else{

            $newDate = date("Y-m-d");

            $data = DB::table('exchange_rate')
                ->where('status', self::STATUS_ACTIVE)
                ->orderBy('id','DESC')->first();

            return $data;

        }

    }

    public static function currencyRates($currCurrencyCode,$newCurrencyCode,$postDate){
        $amount = 1;
        $defaultCurrStatus = self::firstRow2('currency','default_curr_status',self::STATUS_ACTIVE,'code',$newCurrencyCode);
        if(!empty($defaultCurrStatus)){
            $defaultCurr = $defaultCurrStatus->default_curr;
            $converted = ($currCurrencyCode == $newCurrencyCode) ? $amount : $defaultCurr*$amount;
            return $converted;
        }

        $dateRates = self::ratesBasedOnDate($postDate);

        $curr = 'USD'.$currCurrencyCode;

        $rates = json_decode($dateRates,true);
        $currRate = $rates['quotes'][$curr];
        $dollarAmt = $amount/$currRate;
        $new = 'USD'.$newCurrencyCode;
        $newRate = $rates['quotes'][$new];
        $converted = $dollarAmt*$newRate;
        return $converted;



    }

    public static function warehouseData(){
        $data =  DB::table('warehouse')->where('status', self::STATUS_ACTIVE)->get(['id','name','code']);
        return $data;
    }

    public static function taxData(){
        $data =  DB::table('tax')->where('status', self::STATUS_ACTIVE)->get();
        return $data;
    }

    public static function checkEmptyArrayItem($array,$item,$replaceItem){
        if(is_array($array)){
            if(array_key_exists($item, $array)){
                return $array[$item];
            }
        }
       
        return $replaceItem;
    }

    public static function checkEmptyItem($item,$replaceItem){
        if(!empty($item)){
            return $item;
        }
        return $replaceItem;
    }

    public static function jsonUrlDecode($data){
        $decoded = utf8_decode(urldecode($data));
        return json_decode($decoded);
        //return $decoded;
    }

    public static function urlDecode($data){
        $decoded = utf8_decode(urldecode($data));
        return $decoded;
        //return $decoded;
    }

    public static function removeJsonItem($json,$item){

        $oldAttachment = json_decode($json,true);

        if(count($oldAttachment) >0){
            foreach($oldAttachment as $key => $val){
                if($val == $item){
                    $fileUrl = Utility::FILE_URL($item);
                    unset($oldAttachment[$key]);
                    unlink($fileUrl);
                }
            }
        }
        $attachJson = json_encode($oldAttachment);
        return $attachJson;

    }

    public static function checkAuth($guard){
        if(Auth::guard($guard)->check()){
            return Auth::guard($guard)->user();
        }else{
            return Auth::user();
        }
    }

    public static function authColumn($guard){
        if(Auth::guard($guard)->check()){
            return 'temp_user';
        }else{
            return 'assigned_user';
        }
    }

    public static function authTable($guard){
        if(Auth::guard($guard)->check()){
            return 'temp_users';
        }else{
            return 'users';
        }
    }

    public static function authSurveyTable($guard){
        if(Auth::guard($guard)->check()){
            return 'survey_temp_user_ans';
        }else{
            return 'survey_user_ans';
        }
    }

    public static function authBlade($guard,$mainBlade,$otherBlade){
        if(Auth::guard($guard)->check()){
            return $otherBlade;
        }else{
            return $mainBlade;
        }
    }

    public static function authTestTable($guard){
        if(Auth::guard($guard)->check()){
            return 'test_temp_user_ans';
        }else{
            return 'test_user_ans';
        }
    }

    public static function authLink($guard){
        if(Auth::guard($guard)->check()){
            return '/temp';
        }else{
            return '';
        }
    }

    public static function processProjectItem($project){

        $project->task = self::countData2('tasks','project_id',$project->id,self::authColumn('temp_user'),self::checkAuth('temp_user')->id);
        $project->milestone = self::countData('milestones','project_id',$project->id);
        $project->task_list = self::countData('task_lists','project_id',$project->id);
        $project->change_log = self::countData('change_logs','project_id',$project->id);
        $project->decision = self::countData('decisions','project_id',$project->id);
        $project->deliverables = self::countData('deliverables','project_id',$project->id);
        $project->risk = self::countData('risks','project_id',$project->id);
        $project->assump = self::countData('assump_constraints','project_id',$project->id);
        $project->issues = self::countData('issues','project_id',$project->id);
        $project->lesson_learnt = self::countData('lessons_learnt','project_id',$project->id);
        $project->documents = self::countData('project_docs','project_id',$project->id);
        $project->requests = self::countData2('project_member_request','project_id',$project->id,self::authColumn('temp_user'),self::checkAuth('temp_user')->id);
        $project->all_requests = self::countData2('project_member_request','project_id',$project->id,'response_status',self::ZERO);
        $project->members = self::countData('project_team','project_id',$project->id);
        $project->timesheet = self::countData2('timesheet','project_id',$project->id,self::authColumn('temp_user'),self::checkAuth('temp_user')->id);

        return $project;

    }

    public static function taskVal($statusInt){
        $status = '';
        foreach(self::TASK_STATUS as $key => $val){
            if($statusInt == $key){
                $status = $val;
            }
        }
        return $status;
    }

    //TASK_STATUS = ['Not Started','In Progress','On Hold','Completed','Cancelled','Waiting'];

    public static function taskColor($statusInt){
        $status = '';

        switch ($statusInt) {
            case '0':
                $status = '';
                break;
            case '1':
                $status = 'btn-primary';
                break;
            case '2':
                $status = 'btn-warning';
                break;
            case '3':
                $status = 'btn-success';
                break;
            case '4':
                $status = 'btn-danger';
                break;
            case '5':
                $status = 'btn-info';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function daysDuration($start,$end){
        $dateDiff = strtotime($end) - strtotime($start);
        $duration = self::roundNum($dateDiff/(60*60*24));
        return $duration.' day(s)';
    }

    public static function approveStatus($statusInt){
        $status = '';

        switch ($statusInt) {
            case '0':
                $status = 'Processing';
                break;
            case '1':
                $status = 'Approved';
                break;
            case '2':
                $status = 'Denied';
                break;

            default:
                $status = 'Processing';
                break;
        }
        return $status;
    }

    public static function defaultStatus($statusInt){
        $status = '';

        switch ($statusInt) {
            case '0':
                $status = 'Open';
                break;
            case '1':
                $status = 'Closed';
                break;

            default:
                $status = 'Processing';
                break;
        }
        return $status;
    }

    public static function statusDisplayIndicator($statusInt){
        $status = '';

        switch ($statusInt) {
            case '0':
                $status = 'btn-danger';
                break;

            default:
                $status = 'btn-success';
                break;
        }
        return $status;
    }

    public static function statusIndicator($statusInt){
        $status = '';

        switch ($statusInt) {
            case '0':
                $status = 'btn-primary';
                break;
            case '1':
                $status = 'btn-success';
                break;
            case '2':
                $status = 'btn-danger';
                break;

            default:
                $status = 'btn-primary';
                break;
        }
        return $status;
    }

    public static function opportunityStatusIndicator($statusInt){
        $status = '';

        switch ($statusInt) {
            case self::ONGOING :
                $status = 'alert-info';
                break;
            case self::WON:
                $status = 'alert-success';
                break;
            case self::LOST:
                $status = 'alert-danger';
                break;

            default:
                $status = 'alert-info';
                break;
        }
        return $status;
    }

    public static function opportunityStatus($statusInt){
        $status = '';

        switch ($statusInt) {
            case self::ONGOING :
                $status = 'Ongoing';
                break;
            case self::WON:
                $status = 'Won';
                break;
            case self::LOST:
                $status = 'Lost';
                break;

            default:
                $status = 'Ongoing';
                break;
        }
        return $status;
    }

    public static function moduleAccessCheck($table){
        $data = self::firstRow($table,'user_id',Auth::user()->id);
        if(empty($data)){
            return false;
        }
        return true;
    }

    public static function sessionStatusDisplay($statusInt){
        if($statusInt == 1){
            return 'Visible to participants';
        }
        return 'Invisible to participants';
    }

    public static function budgetStatusReadyDisplay($statusInt){
        if($statusInt == 1){
            return 'Ready for Approval';
        }
        return 'Not Ready for Approval';
    }

    public static function hseReportType($reportType){
        if($reportType == 1){
            return 'Incident';
        }
        return 'Hazard';
    }

    public static function eventType($reportType){
        if($reportType == 1){
            return 'My Schedule';
        }
        return 'General Schedule';
    }

    public static function statusDisplay($statusInt){
        if($statusInt == 1){
            return 'Active';
        }
        return 'Inactive';
    }

    public static function createData($table,$dataArray){
        $insertData =DB::table($table)->insert($dataArray);
        return $insertData;
    }

    public static function surveyPercentClass($val){
        $htmlClass = '';
        if($val < 40){
            $htmlClass = 'progress-bar-danger';
        }
        if($val > 39 && $val < 50){
            $htmlClass = 'progress-bar-warning';
        }
        if($val > 49 && $val < 70){
            $htmlClass = 'progress-bar-info';
        }
        if($val > 69){
            $htmlClass = 'progress-bar-success';
        }
        return $htmlClass;
    }

    public static function doubleItemsType2($arrOne=[]){
        $objects = [];
        foreach ($arrOne as $k => $v){
            $objects[] = $v;
        }
        $hold_objects = [];
        for($i=0; $i<count($objects);$i++){
            for($j=$i+1; $j<count($objects); $j++){
                if($objects[$j] == $objects[$i]){
                    if(!in_array($objects[$i],$hold_objects)){
                        $hold_objects[] = $objects[$j];
                    }

                }
            }
            }
            return $hold_objects;
        }

    public static function doubleItems($objects=[]){
        $hold_objects = [];
        for($i=0; $i<count($objects);$i++){
            for($j=$i+1; $j<count($objects); $j++){
                if($objects[$j] == $objects[$i]){
                    if(!in_array($objects[$i],$hold_objects)){
                        $hold_objects[] = $objects[$j];
                    }

                }
            }
        }
            return $hold_objects;
    }

    public static function arrHighestScoreSurvey($arr){
        $normArr = [];
        $newArr = [];
        $convertArr = [];
        $val = '';
        $largest = 0;

            $twiceArr = self::doubleItemsType2($arr);
        if(!empty($twiceArr)) {

            foreach ($arr as $k => $v) {
                foreach ($twiceArr as $t) {
                    if ($t == $v) {
                        $newArr[$k] = $v;
                        unset($arr[$k]);
                    }
                }
            }

            foreach ($newArr as $k => $v) {
                $convertArr[$v][] = $k;
            }

            foreach ($convertArr as $k => $v) {
                $sum = self::roundNum(array_sum($v) / count($v));
                $arr[$sum] = $k;
            }
        }

        foreach($arr as $a){
            if($largest < $a){
                $largest = $a;
            }
        }
        foreach($arr as $key => $var){
            if($var == $largest){
                $val = $key;
            }
        }
        return $val;
    }

    public static function validatePinCode($pinCode){
        $data = self::firstRow('user_pin_code','pin_code',$pinCode);
        if(empty($data)){
            exit(json_encode([
                'message2' => 'Pin code incorrect, please contact the administrator',
                'message' => 'incorrect'
            ]));
        }
    }

    public static function decodeUriData($string){
        $output = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($string));
        return html_entity_decode($output,null,'UTF-8');

    }

    public static function quickNotes(){

        $data = QuickNote::where('status', self::STATUS_ACTIVE)->where('created_by',Auth::user()->id)->orderBy('id','DESC')->get();

        return $data;

    }

    public static function driverVehicles(){

        $data = Vehicle::specialColumns('driver_id',Auth::user()->id);

        return $data;

    }

    public static function budgetRequestCompare($requisitions,$budget){
        $holdComparison = [];
        foreach($requisitions as $rKey => $request){

            foreach ($budget as $bKey => $b){
                if($rKey == $bKey){
                    $holdComparison[$rKey] = $request.'|'.$b;
                }
            }

        }

        return $holdComparison;

    }

    public static function budgetBudgetCompare($budget1,$budget2){
        $holdComparison = [];
        foreach($budget1 as $rKey => $b1){

            foreach ($budget2 as $bKey => $b2){
                if($rKey == $bKey){
                    $holdComparison[$rKey] = $b1.'|'.$b2;
                }
            }

        }

        return $holdComparison;

    }

    public static function fetchBOMItems($mainData){

        foreach($mainData as $data){
            $bomData = [];
            if($data->item_id != '') {
                if ($data->inventory->assemble_bom == 'checked') {
                    $bomData = InventoryBom::specialColumns('inventory_id', $data->item_id);
                }
            }
            $data->bomData = $bomData;
        }

    }

    public static function addDaysToDate($days){
        $Date = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime($Date. ' + '.$days.' days'));
        if($days > 0 && $days != ''){
            return $newDate;
        }
        $newDate = date('Y-m-d', strtotime($Date. ' - 1 days'));
        return $newDate;
    }

    public static function monthName($monthNum){

        switch ($monthNum) {
            case 'month_1' :
                $month = 'Jan';
                break;
            case 'month_2':
                $month = 'Feb';
                break;
            case 'month_3':
                $month = 'March';
                break;
            case 'month_4' :
                $month = 'April';
                break;
            case 'month_5':
                $month = 'May';
                break;
            case 'month_6':
                $month = 'June';
                break;
            case 'month_7' :
                $month = 'July';
                break;
            case 'month_8':
                $month = 'August';
                break;
            case 'month_9':
                $month = 'Sept';
                break;
            case 'month_10' :
                $month = 'Oct';
                break;
            case 'month_11':
                $month = 'Nov';
                break;
            case 'month_12':
                $month = 'Dec';
                break;

            default:
                $month = 'Jan';
                break;
        }
        return $month;
    }

    public static function budgetRequestTracking($department,$requestCategory,$amount){

        $financialYear = self::firstRow('financial_year','active_status',self::STATUS_ACTIVE);
        if(!empty($financialYear)){
            $activeBudget = self::firstRow('budget_request_tracking','active_status',self::STATUS_ACTIVE);

            if(!empty($activeBudget)){
                self::budgetTrack($activeBudget->id,$department,$requestCategory,$amount);
            }

        }

    }

    public static function budgetTrack($trackType,$department,$requestCategory,$amount){
        $budget = 0;
        $monthInt = date('n');
        $month = date('m');
        $year = date('Y');
        $lastDay = date('t',strtotime('today'));
        $totalReq = 0;

        //MONTHLY
        if($trackType == 1){
            $dbDataSum = self::sumColumnDataCondition('budget','dept_id',$department,self::monthName('month_'.$monthInt));
            $budget = (empty($dbDataSum)) ? 0 : $dbDataSum;
            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->whereBetween('created_at', [$year.'-'.$month.'-01',$year.'-'.$month.'-'.$lastDay])
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalReq = (empty($totalReqSum)) ? 0 : $totalReqSum;

            if($budget > ($totalReq+$amount)){

            }else{
                exit(json_encode([
                    'message2' => 'You have exceeded your monthly budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount,
                    'message' => 'currency inactive'
                ]));
            }

        }

        //QUARTERLY
        if($trackType == 2){
            $dbDataSum =  self::sumColumnDataCondition('budget','dept_id',$department,self::setQuarterWithMonth($monthInt));
            $budget = (empty($dbDataSum)) ? 0 : $dbDataSum;
            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->whereBetween('created_at', self::dbQuarterDateArr(date('Y-m-d')))
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalReq = (empty($totalReqSum)) ? 0 : $totalReqSum;

            if($budget > ($totalReq+$amount)){

            }else{
                exit(json_encode([
                    'message2' => 'You have exceeded your quarterly budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount,
                    'message' => 'currency inactive'
                ]));
            }

        }
        //HALF YEAR
        if($trackType == 3){
            $dbDataSum = self::sumColumnDataCondition('budget','dept_id',$department,'total_cat_amount');
            $sum = (empty($dbDataSum)) ? 0 : $dbDataSum;
            $budget = $sum/2;

            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->whereBetween('created_at', [$year.'-01-01',$year.'-12-'.$lastDay])
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalSum = (empty($totalReqSum)) ? 0 : $totalReqSum;
            $totalReq = $totalSum/2;

            if($budget > ($totalReq+$amount)){

            }else{
                exit(json_encode([
                    'message2' => 'You have exceeded your half year budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount,
                    'message' => 'currency inactive'
                ]));
            }

        }

        //YEARLY
        if($trackType == 4){
            $dbDataSum = self::sumColumnDataCondition('budget','dept_id',$department,'total_cat_amount');
            $budget = (empty($dbDataSum)) ? 0 : $dbDataSum;

            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->whereBetween('created_at', [$year.'-01-01',$year.'-12-'.$lastDay])
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalReq = (empty($totalReqSum)) ? 0 : $totalReqSum;

            if($budget > ($totalReq+$amount)){

            }else{
                exit(json_encode([
                    'message2' => 'You have exceeded your yearly budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount,
                    'message' => 'currency inactive'
                ]));
            }

        }

        //MONTHLY CATEGORY
        if($trackType == 5){

            $dbDataSum = self::sumColumnDataCondition2('budget','dept_id',$department,'request_cat_id',$requestCategory,self::monthName('month_'.$monthInt));
            $budget = (empty($dbDataSum)) ? 0 : $dbDataSum;

            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->where('req_cat', $requestCategory)
                ->whereBetween('created_at', [$year.'-'.$month.'-01',$year.'-'.$month.'-'.$lastDay])
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalReq = (empty($totalReqSum)) ? 0 : $totalReqSum;

            if($budget > ($totalReq+$amount)){

            }else{
                exit(json_encode([
                    'message2' => 'You have exceeded your monthly budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount.' for this category',
                    'message' => 'currency inactive'
                ]));
            }

        }

        //QUARTERLY CATEGORY
        if($trackType == 6){
            $dbDataSum =  self::sumColumnDataCondition2('budget','dept_id',$department,'request_cat_id',$requestCategory,self::setQuarterWithMonth($monthInt));
            $budget = (empty($dbDataSum)) ? 0 : $dbDataSum;

            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->where('req_cat', $requestCategory)
                ->whereBetween('created_at', self::dbQuarterDateArr(date('Y-m-d')))
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalReq = (empty($totalReqSum)) ? 0 : $totalReqSum;

            if($budget > ($totalReq+$amount)){

            }else{
                exit(json_encode([
                    'message2' => 'You have exceeded your quarterly budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount.' for this category',
                    'message' => 'currency inactive'
                ]));
            }

        }
        //HALF YEAR CATEGORY
        if($trackType == 7){
            $dbDataSum = self::sumColumnDataCondition2('budget','dept_id',$department,'request_cat_id',$requestCategory,'total_cat_amount');
            $sum = (empty($dbDataSum)) ? 0 : $dbDataSum;
            $budget = $sum/2;

            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->where('req_cat', $requestCategory)
                ->whereBetween('created_at', [$year.'-01-01',$year.'-12-'.$lastDay])
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalSum = (empty($totalReqSum)) ? 0 : $totalReqSum;
            $totalReq = $totalSum/2;

            if($budget > ($totalReq+$amount)){

            }else{
                exit(json_encode([
                    'message2' => 'You have exceeded your half year budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount.' for this category',
                    'message' => 'currency inactive'
                ]));
            }

        }

        //YEARLY CATEGORY
        if($trackType == 8){
            $dbDataSum = self::sumColumnDataCondition2('budget','dept_id',$department,'request_cat_id',$requestCategory,'total_cat_amount');
            $budget = (empty($dbDataSum)) ? 0 : $dbDataSum;

            $totalReqSum = DB::table('requisition')
                ->where('dept_id', $department)
                ->where('hr_accessible','!=', '1')
                ->where('req_cat', $requestCategory)
                ->whereBetween('created_at', [$year.'-01-01',$year.'-12-'.$lastDay])
                ->where('status', self::STATUS_ACTIVE)
                ->sum('amount');
            $totalReq= (empty($totalReqSum)) ? 0 : $totalReqSum;

        }

        if($budget > ($totalReq+$amount)){

        }else{
            exit(json_encode([
                'message2' => 'You have exceeded your yearly budget '.self::defaultCurrency().$budget.' by an addition of'.self::defaultCurrency().$amount.' for this category',
                'message' => 'currency inactive'
            ]));
        }

    }

    public static function setQuarterWithMonth($monthInt){
        $quarter = 'Nil';
        if($monthInt <= 3){
            $quarter = 'first_quarter';
        }
        if($monthInt >= 4 && $monthInt <= 6 ){
            $quarter = 'second_quarter';
        }
        if($monthInt >= 7 && $monthInt <= 9 ){
            $quarter = 'third_quarter';
        }
        if($monthInt >= 10 && $monthInt <= 12 ){
            $quarter = 'fourth_quarter';
        }

        return $quarter;

    }

    public static function dbQuarterDateArr($date){
        $quarterDateArr = [];
        $year = date('Y');
        $lastDay = date('t',strtotime('today'));
        if($date <= $year.'-03-'.$lastDay){
            $quarterDateArr = [$year.'-01-01',$year.'-03-31'];
        }
        if($date <= $year.'-06-'.$lastDay && $date >= $year.'-04-'.$lastDay){
            $quarterDateArr = [$year.'-04-01',$year.'-06-30'];
        }
        if($date <= $year.'-09-'.$lastDay && $date >= $year.'-07-'.$lastDay){
            $quarterDateArr = [$year.'-07-01',$year.'-09-30'];
        }
        if($date <= $year.'-09-'.$lastDay && $date >= $year.'-07-'.$lastDay){
            $quarterDateArr = [$year.'-10-01',$year.'-12-31'];
        }

        return $quarterDateArr;

    }

    public static function OpeningBalanceObject($newAccountCategoryId){

        $acctCategoryId = ($newAccountCategoryId == self::OPENING_BALANCE_ACCOUNT_CATEGORY_ID) ? self::BANK_ACCT_CAT_ID : self::OPENING_BALANCE_ACCOUNT_CATEGORY_ID;
        $acctDetailId = ($newAccountCategoryId == self::OPENING_BALANCE_ACCOUNT_CATEGORY_ID) ? self::BANK_DETAIL_ID : self::OPENING_BALANCE_DETAIL_ID;
        $acctChartId = ($newAccountCategoryId == self::OPENING_BALANCE_ACCOUNT_CATEGORY_ID) ? self::DEFAULT_BANK_ID_ACCOUNT_CHART : self::OPENING_BALANCE_EQUITY_CHART_ID;

        $accountData = AccountChart::firstRow('id',$acctChartId);
        

        $obj = new \stdClass();
        $obj->acctCategoryId = $acctCategoryId;
        $obj->acctDetailId = $acctDetailId;
        $obj->acctChartId = $acctChartId;
        $obj->secondCurrCode = $accountData->chartCurr->code;

        return $obj;

    }

    public static function updateAccountBalance($accountChartId,$amountTrans,$debitCredit){ //UPDATE CURRENT ACCOUNT BALANCE IN CHART OF ACCOUNTS

        $accountData = DB::table('account_chart')->where('id',$accountChartId)->where('status',self::STATUS_ACTIVE)->first();
        $acctCurrency = Currency::firstRow('id',$accountData->curr_id);
        $defaultCurr = Finance::defaultCurrObj();

        $currBalance = (empty($accountData->virtual_balance)) ? 0.00 :$accountData->virtual_balance;
        $currBalanceTrans = (empty($accountData->virtual_balance_trans)) ? 0.00 :$accountData->virtual_balance_trans;
        $acctCategoryId = $accountData->acct_cat_id;
        $amount =  Utility::convertAmount($defaultCurr->code,$acctCurrency->code,$amountTrans);
        
        $newBalance = $amount;    $newBalanceTrans = $amountTrans;

        //IF THE CATEGORY EXIST IN THE ARRAY BELOW THEN IT IS A DEBIT ACCOUNT, MEANING THAT A DEBIT INCREASES THE ACCOUNT AND CREDIT DECREASES THE ACCOUNT BALANCE
        if(in_array($acctCategoryId,self::DEBIT_ACCOUNTS)){  //ALL THE ACCOUNTS IN THIS ARRAY ARE DEBIT ACCOUNTS, SO WHEN DEBITED, CREDITS OPEN BALANCE EQUITY ACCOUNT
                $newBalance = ($debitCredit == self::DEBIT_TABLE_ID) ? $currBalance + $amount : $currBalance - $amount;
                $newBalanceTrans = ($debitCredit == self::DEBIT_TABLE_ID) ? $currBalanceTrans + $amountTrans : $currBalanceTrans - $amountTrans;
        }

        //IF THE CATEGORY EXIST IN THE ARRAY BELOW THEN IT IS A CREDIT ACCOUNT, MEANING THAT A CREDIT INCREASES THE ACCOUNT AND DEBIT DECREASES THE ACCOUNT BALANCE
        if(in_array($acctCategoryId,self::CREDIT_ACCOUNTS) || $acctCategoryId == self::OPENING_BALANCE_ACCOUNT_CATEGORY_ID){  //ALL THE ACCOUNTS IN THIS ARRAY ARE CREDIT ACCOUNTS, SO WHEN CREDITED, DEBITS OPEN BALANCEEQUITY ACCOUNT
            $newBalance = ($debitCredit == self::CREDIT_TABLE_ID) ? $currBalance + $amount : $currBalance - $amount;
            $newBalanceTrans = ($debitCredit == self::CREDIT_TABLE_ID) ? $currBalanceTrans + $amountTrans : $currBalanceTrans - $amountTrans;
        
            //IF ACCOUNT IS A CREDIT CARD ACCOUNT CATEGORY
            if(self::CREDIT_CARD_CATEGORY_ID == $acctCategoryId){
                $newBalance = ($debitCredit == self::CREDIT_TABLE_ID) ? $currBalance - $amount : $currBalance + $amount;
                $newBalanceTrans = ($debitCredit == self::CREDIT_TABLE_ID) ? $currBalanceTrans - $amountTrans : $currBalanceTrans + $amountTrans;
        
            }
        
        }

        AccountChart::defaultUpdate('id',$accountChartId,['virtual_balance'=> Utility::roundNum($newBalance),'virtual_balance_trans'=> self::roundNum($newBalanceTrans)]);
       

    }

    public static function accountStatus(){

        return DB::table('account_status')->where('status', self::STATUS_ACTIVE)->get();



    }

    public static function roundNum($num,$decimalParam = 2){
        $decimal = '%.'.$decimalParam.'f';
        $round = sprintf($decimal,$num);
        return $round;
    }

    public static function numberFormat($num,$decimalParam =2){
        $floatNum = floatval($num);
        $format = number_format($floatNum,$decimalParam,'.',', ');
        return $format;
    }


}