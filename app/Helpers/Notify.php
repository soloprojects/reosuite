<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 3/8/2018
 * Time: 9:22 AM
 */

namespace App\Helpers;

use App\Jobs\SendAdminRequestEmail;
use App\Jobs\SendAppraisalEmail;
use App\Jobs\SendDemoEmail;
use App\Jobs\SendGeneralEmail;
use App\Jobs\SendJournalEmail;
use App\Jobs\SendLeaveRequestEmail;
use App\Jobs\SendPayrollEmail;
use App\Jobs\SendPoEmail;
use App\Jobs\SendQuoteEmail;
use App\Jobs\SendRfqEmail;
use App\Jobs\SendSalesEmail;
use App\Jobs\SendWarehouseEmail;
use App\model\VehicleFleetAccess;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use view;
use Illuminate\Support\Facades\Session;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Storage;
use App\Mail\DemoMail;
use App\Mail\LeaveRequestMail;
use App\Mail\PoMail;
use App\Mail\rfqMail;
use App\Mail\SalesMail;
use App\Mail\quoteMail;
use App\Mail\AppraisalMail;
use App\Mail\AdminMail;
use App\Mail\AdminRequestMail;
use App\Mail\GeneralMail;
use App\Mail\JournalMail;
use App\Mail\PayrollMail;

class Notify
{


    //SEND REQUISITION MAIL
    public static function sendMail($viewPage,$arrayContent = [],$email,$fullName = '',$subject = ''){
        
        //Mail::to($email)->send(new DemoMail($arrayContent));
        //dispatch(new SendDemoEmail($email,$arrayContent));
    }

    public static function appraisalMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new AppraisalMail($objContent));
        //dispatch(new SendAppraisalEmail($email,$objContent));
    }

    public static function leaveRequestMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new LeaveRequestMail($objContent));
        //dispatch(new SendLeaveRequestEmail($email,$objContent));
    }

    public static function payrollMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new PayrollMail($objContent));
        //dispatch(new SendPayrollEmail($email,$objContent));
    }

    public static function poMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new PoMail($objContent));
        //dispatch(new SendPoEmail($email,$objContent));
    }

    public static function rfqMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new rfqMail($objContent));
       // dispatch(new SendRfqEmail($email,$objContent));
    }

    public static function warehouseMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new WarehouseMail($objContent));
        //dispatch(new SendWarehouseEmail($email,$objContent));
    }

    public static function quoteMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new quoteMail($objContent));
        //dispatch(new SendQuoteEmail($email,$objContent));
    }

    public static function GeneralMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new GeneralMail($objContent));
        //dispatch(new SendGeneralEmail($email,$objContent));
    }

    public static function AdminMail($viewPage,$arrayContent = [],$email,$fullName = '',$subject = ''){

        //Mail::to($email)->send(new AdminMail($arrayContent));
        //dispatch(new SendAdminRequestEmail($email,$arrayContent));
    }

    public static function VehicleMaintenanceScheduleReminder($vehicle,$serviceArr)
    {
        $fleetManagers = VehicleFleetAccess::getAllData();
        foreach ($fleetManagers as $userData) {
            $userEmail = $userData->reqUser->email;

            $mailContent = [];

            $messageBody = "Hello " . $userData->reqUser->firstname . ", the vehicle " . $vehicle->make->make_name
                . " " . $vehicle->model->model_name . " " . $vehicle->model_year . " with license plate "
                . $vehicle->license_plate . " is due for the following maintenance, " .
                implode(',', $serviceArr) . ", please ensure to service the vehicle assigned to" .
                $vehicle->driver->firstname . " " . $vehicle->driver->lastname .
                ", please visit the portal for more info";

            $mailContent['message'] = $messageBody;
            self::GeneralMail('mail_views.general', $mailContent, $userEmail);

        }
    }

    public static function salesMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new salesMail($objContent));
        //dispatch(new SendSalesEmail($email,$objContent));
    }

    public static function journalMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new journalMail($objContent));
        //dispatch(new SendJournalEmail($email,$objContent));
    }

}