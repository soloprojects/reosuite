<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\TempUsers;
use App\User;
use Illuminate\Console\Command;

class BirthdayForTempUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:BirthdayForTempUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out email to temporary users who have birthday, and notifies people of other peoples birthday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $today = date('Y-m-d');
        $month = date('m');
        $day = date('d');
        $birthdayUsersArr = [];
        $birthdayNames = [];
        $birthdayUsers =  TempUsers::specialColumns('active_status',Utility::STATUS_ACTIVE);
        foreach ($birthdayUsers as $userData){

            $birthDate = strtotime($userData->dob);

            $birthDay = date('d', $birthDate);
            $birthMonth = date('m', $birthDate);
            $birthdayUsersArr[] = $userData->id;
            $userEmail = $userData->email;
            $names = $userData->firstname.' '.$userData->lastname;
            $birthdayNames[] = $names;

            $mailContent = [];
            //Log::info($birthDay.''.$today.'month='.$birthMonth.''.$month);
            $messageBody = "Dear " . $userData->firstname . ", we realize how important today is to you.
            Birthdays comes once in a year, so we celebrate you today. Happy birthday, and have an amazing year.
            From ".Utility::companyInfo()->name;

            if($birthDay == $day && $birthMonth == $month){
                $mailContent['message'] = $messageBody;
                Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
            }

        }

        
    }
}
