<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\Vehicle;
use App\model\VehicleFleetAccess;
use App\model\VehicleMaintenanceReminder;
use App\model\VehicleOdometerLog;
use App\model\VehicleServiceType;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\model\VehicleMaintenanceSchedule;

class VehicleMaintenanceScheduling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:VehicleMaintenanceScheduling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail notifications to drivers and fleet managers when vehicle is due for maintenance';

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
        $VMSchedule = VehicleMaintenanceSchedule::getAllData();
        foreach ($VMSchedule as $schedule){
            $mileageDuringSchedule = $schedule->mileage;
            $serviceTypeArr = json_decode($schedule->reminder->service_types,true);
            $serviceTypes = VehicleServiceType::massData('id',$serviceTypeArr);
            $vehicle = Vehicle::firstRow('id',$schedule->vehicle_id);
            $serviceArr = [];
            if(!empty($serviceTypes)){
                foreach($serviceTypes as $type){
                    $serviceArr[] = $type->name;
                }
            }

            //MESSAGE BODY AND CONTENT TO PUSH OUT TO DRIVER
            $mailContent = [];
            $messageBody = "Hello ".$vehicle->driver->firstname.", the vehicle ".$vehicle->make->make_name
                ." ".$vehicle->model->model_name." ".$vehicle->model_year." with license plate "
                .$vehicle->license_plate." is due for the following maintenance, ".
                implode(',',$serviceArr).", please ensure to service the vehicle assigned to".
                $vehicle->driver->firstname."".$vehicle->driver->lastname.
                ", please visit the portal to join discussion";

            $mailContent['message'] = $messageBody;

            $lastVehicleOdometerRecord = VehicleOdometerLog::where('status', '=',Utility::STATUS_ACTIVE)
                ->where('vehicle_id', '=',$schedule->vehicle_id)->orderBy('id','DESC')->first();


                //CHECK IF THE VEHICLE HAVE ACCUMULATED A CERTAIN MILEAGE THAT REQUIRES MAINTENANCE
                $lastVehicleMileage = (!empty($lastVehicleOdometerRecord)) ? $lastVehicleOdometerRecord->end_mileage : $vehicle->mileage;
                $accumulatedMileage = $lastVehicleMileage - $mileageDuringSchedule;
                if($accumulatedMileage >= $schedule->reminder->mileage){
                    Notify::VehicleMaintenanceScheduleReminder($vehicle,$serviceArr);
                    Notify::GeneralMail('mail_views.general', $mailContent, $vehicle->driver->email);
                    }


                $today = date('Y-m-d');

                //CHECK MAIL NOTIFICATION DATE IF TODAY SEND OUT MAIL
                if(!empty($schedule->reminder->last_reminder)){
                    $dateTime1 = Carbon::parse($schedule->reminder->last_reminder)->subDays(2);
                    $dateTime2 = Carbon::parse($schedule->reminder->last_reminder)->subDays(1);

                    if($today == $schedule->reminder->last_reminder ||
                        $dateTime1 == $schedule->reminder->last_reminder ||
                        $dateTime2 == $schedule->reminder->last_reminder){

                        Notify::VehicleMaintenanceScheduleReminder($vehicle,$serviceArr);
                        Notify::GeneralMail('mail_views.general', $mailContent, $vehicle->driver->email);
                    }
                }

                //CHECK INTERVAL, SEND MAIL AND UPDATE NEXT DATE OF INTERVAL
            if(!empty($schedule->reminder->interval)) {
                $dateTime1 = Carbon::parse($schedule->reminder->next_reminder)->subDays(2);
                $dateTime2 = Carbon::parse($schedule->reminder->next_reminder)->subDays(1);
                if ($today == $schedule->reminder->next_reminder ||
                    $dateTime1 == $schedule->reminder->next_reminder ||
                    $dateTime2 == $schedule->reminder->next_reminder){
                    Notify::VehicleMaintenanceScheduleReminder($vehicle, $serviceArr);
                    Notify::GeneralMail('mail_views.general', $mailContent, $vehicle->driver->email);

                    $newNextDate = date('Y-m-d', strtotime($today . ' + ' . $schedule->reminder->interval . ' days'));

                    VehicleMaintenanceReminder::defaultUpdate('id',$schedule->reminder_id,['next_reminder'=>$newNextDate]);
                }
            }


        }


    }



}
