<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\Events;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EventReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:EventReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail three times ahead of the event day and time';

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
        $events = Events::getAllData();
        foreach($events as $val){
            if($val->start_event > date('Y-m-d H:i:s')){
                $dateTime1 = Carbon::parse($val->start_event)->subDays(2);
                $dateTime2 = Carbon::parse($val->start_event)->subMinutes(45);
                $dateTime3 = Carbon::parse($val->start_event)->subMinutes(10);
                $currentDateTime = Carbon::now();

                if($currentDateTime == $dateTime1 || $currentDateTime == $dateTime2 || $currentDateTime == $dateTime3){

                    if($val->event_type == Utility::GENERAL_SCHEDULE){

                        $activeUsers = User::specialColumns('active_status',Utility::STATUS_ACTIVE);

                        foreach ($activeUsers as $userData){
                            $userEmail = $userData->email;

                            $mailContent = [];

                            $messageBody = "Hello '.$userData->firstname.', an event with title ".$val->event_title." will
                    start by ".$val->start_event." and ends by".$val->end_event.", this is just to inform you
                     ahead of time.";

                            $mailContent['message'] = $messageBody;
                            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                        }

                    }else{
                        $userData = User::firstRow('',$val->user->id);
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello '.$userData->firstname.', an event with title ".$val->event_title." will
                    start by ".$val->start_event." and ends by".$val->end_event.", this is just to inform you
                     ahead of time.";

                        $mailContent['message'] = $messageBody;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);

                    }

                }
            }
        }

    }
}
