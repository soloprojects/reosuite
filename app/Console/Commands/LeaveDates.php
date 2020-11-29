<?php

namespace App\Console\Commands;

use App\model\LeaveVacationDates;
use Illuminate\Console\Command;
use DB;
use App\Helpers\Utility;
use App\Helpers\Notify;
use Illuminate\Support\Facades\Mail;

class LeaveDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LeaveDates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users on the prefered period they choose to go for leave vacation/holiday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function push_mail($userEmail,$weekDate,$month,$firstname,$lastname){
        $mailContent = [];
                $realMonth = date("F", strtotime("1970-" . $month . "-01"));

                $messageBody = "Hello  $firstname, just a reminder that you informed HR that you might be taking your leave on $realMonth starting from
                $weekDate of $realMonth<br/> <br/> Login to the portal to apply for leave.  ";

                $mailContent['message'] = $messageBody;
                Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        

        $currMonth = date('n');
        $currYear = date('Y');
        $useMonth = $currMonth +1;

        $userLeaveDates = LeaveVacationDates::specialColumns2('month',$useMonth,'year',$currYear);
        //$inventoryUsers = Utility::getAllData('inventory_access');

        $inventoryItems = LeaveVacationDates::getAllData();
        if(!empty($userLeaveDates)){
            foreach($userLeaveDates as $item){
               
                $month = $item->month;
            $week = $item->week;
            $year = $item->year;
            $userId = $item->user_id;
            $preMonth = ($month >= 2) ? $month -1 : $month;
            $lastname = $item->user->lastname;
            $firstname = $item->user->firstname;
            $rowId = $item->id;
                        	
            	$to = $item->user->email;
            	
            
            $preWeek = $currYear.'-'.$preMonth.'-'.'1';
            $week2 = date('Y-m-d', strtotime('+1 week', strtotime($preWeek)));
            $week3 = date('Y-m-d', strtotime('+2 weeks', strtotime($week2)));
            $week4 = date('Y-m-d', strtotime('+3 weeks', strtotime($week3)));
            $week5 = date('Y-m-d', strtotime('+4 weeks', strtotime($week4)));
            $week6 = date('Y-m-d', strtotime('+5 weeks', strtotime($week5)));
            $week7 = date('Y-m-d', strtotime('+6 weeks', strtotime($week6)));
            $week8 = date('Y-m-d', strtotime('+7 weeks', strtotime($week7)));
            
            //GET DATE FOR MAIL STOP MONTH
            $weekDate1 = $year.'-'.$month.'-'.'1';
            $weekDate2 = date('Y-m-d', strtotime('+1 week', strtotime($weekDate1)));
            $weekDate3 = date('Y-m-d', strtotime('+2 weeks', strtotime($weekDate2)));
            $weekDate4 = date('Y-m-d', strtotime('+3 weeks', strtotime($weekDate3)));
            $weekDate5 = date('Y-m-d', strtotime('+4 weeks', strtotime($weekDate4)));
            $weekDate6 = date('Y-m-d', strtotime('+5 weeks', strtotime($weekDate5)));
            $weekDate7 = date('Y-m-d', strtotime('+6 weeks', strtotime($weekDate6)));            
            $weekDate8 = date('Y-m-d', strtotime('+7 weeks', strtotime($weekDate7)));
            $currDate = date('Y-m-d');
            $kk = '';
            $kk .= $currDate.'secnd='.$week2.'third='.$weekDate2.$to;
            
             
            if($week == '1'){
            
                if(strtotime($currDate) >= strtotime($preWeek) && strtotime($preWeek) < strtotime($weekDate1)){
                    LeaveVacationDates::defaultUpdate('id',$rowId,['update_status'=>$currDate]);
                    self::pushMail($to,$weekDate1,$month,$firstname,$lastname);
                }
            
            }
            
            if($week == '2'){
                
                if(strtotime($currDate) >= strtotime($week2) && strtotime($week2)< strtotime($weekDate2)){
                    LeaveVacationDates::defaultUpdate('id',$rowId,['update_status'=>$currDate]);
                    self::pushMail($to,$weekDate2,$month,$firstname,$lastname);
                }
                
            }
            
            if($week == '3'){
                
                if(strtotime($currDate) >= strtotime($week3) && strtotime($week3)< strtotime($weekDate3)){
                    LeaveVacationDates::defaultUpdate('id',$rowId,['update_status'=>$currDate]);
                    self::pushMail($to,$weekDate3,$month,$firstname,$lastname);
                }
                
            }
            
            if($week == '4'){
                
                if(strtotime($currDate) >= strtotime($week4) && strtotime($week4)< strtotime($weekDate4)){
                    LeaveVacationDates::defaultUpdate('id',$rowId,['update_status'=>$currDate]);
                    self::pushMail($to,$weekDate4,$month,$firstname,$lastname);
                }
                
            }
            

            }
        }


    }
}
