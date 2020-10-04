<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\InventoryAccess;
use App\model\InventoryContract;
use App\model\InventoryContractItems;
use App\User;
use Illuminate\Console\Command;
use Monolog\Handler\Curl\Util;

class InventoryContractNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:InventoryContractNotify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Admin,Finance,SCM,users accessible to inventory about contract renewal and item servicing';

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
        //ACCOUNT_SCM_WHSE_ADMIN
        $today = date('Y-m-d');
        $contract = InventoryContract::specialColumns('end_date',$today);
        $contractItems = InventoryContractItems::getAllActiveContractItems();

        $inventoryUsers = InventoryAccess::getAllData();
        $invUsersArr = [];
        if(!empty($inventoryUsers)){
            foreach($inventoryUsers as $u){
                $invUsersArr[] = $u->user_id;
            }
        }


        $mergeUsers = array_merge(Utility::ACCOUNT_SCM_WHSE_ADMIN,$invUsersArr);
        $getUsers = User::massData('id',$mergeUsers);

        //SEND MAIL TO SCM,ADMIN,ACCOUNT/FINANCE,WAREHOUSE EMPLOYEES WHEN ITEMS ON CONTRACT IS DUE FOR EXPIRING
        if(!empty($contract)){
            foreach($contract as $con){

                if(!empty($getUsers)){
                    foreach ($getUsers as $user){
                        $mailContent = [];

                        $messageBody = "Hello " . $user->firstname . ", the contract " . $con->name
                            . " which started on " . $con->start_date . " is ending today at date" .
                            $con->end_date;

                        $mailContent['message'] = $messageBody;
                        Notify::GeneralMail('mail_views.general', $mailContent, $user->email);
                    }
                }

                $updateContract = InventoryContract::defaultUpdate('id',$con->id,['active_status'=>Utility::ZERO]);


            }
        }

        //SEND MAIL TO SCM,ADMIN,ACCOUNT/FINANCE,WAREHOUSE EMPLOYEES WHEN ITEMS ON CONTRACT IS DUE FOR SERVICING
        if(!empty($contractItems)){
            foreach ($contractItems as $item){

                $newDate = date('Y-m-d', strtotime($today. ' + '.$item->servicing_interval.' days'));


                if(!empty($getUsers)){
                    foreach ($getUsers as $user){
                        $mailContent = [];

                        $messageBody = "Hello " . $user->firstname . ", the item " . $item->inventory->name
                            . " on a contract " . $item->invContract->name . " is due for servicing and maintenance";

                        $mailContent['message'] = $messageBody;
                        Notify::GeneralMail('mail_views.general', $mailContent, $user->email);
                    }
                }

                $updateContract = InventoryContract::defaultUpdate('id',$item->id,['next_reminder'=>$newDate]);


            }
        }

    }
}
