<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\model\Vehicle;
use Illuminate\Console\Command;

class OdometerLogReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:OdometerLogReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if(date('Y-m-d H:i:s') == date('Y-m-d').' 16:00:00'){
            $vehicles = Vehicle::getAllData();
            foreach($vehicles as $vehicle){
                $userEmail = $vehicle->driver->email;

                $mailContent = [];

                $messageBody = "Hello " . $vehicle->driver->firstname . ", please ensure to log
             the odometer mileage value for the vehicle " . $vehicle->make->make_name
                    . " " . $vehicle->model->model_name . " " . $vehicle->model_year . " with license plate "
                    . $vehicle->license_plate . ", as the vehicle is been assigned to you ";

                $mailContent['message'] = $messageBody;
                Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
            }
        }


    }
}
