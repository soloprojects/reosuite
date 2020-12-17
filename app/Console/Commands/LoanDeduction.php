<?php

namespace App\Console\Commands;

use App\Helpers\Utility;
use App\model\Requisition;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class LoanDeduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LoanDeduction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update and service loan requests from users';

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

        $dbData = DB::table('requisition')
            ->where('accessible_status', Utility::STATUS_ACTIVE)
            ->where('complete_status', Utility::STATUS_ACTIVE)
            ->where('finance_status', Utility::STATUS_ACTIVE)
            ->where('loan_balance', '>', '0')
            ->where('status', Utility::STATUS_ACTIVE)
            ->get();

        if(!empty($dbData)){

            foreach ($dbData as $data){

                $newLoanBalance = $data->loanBalance - $data->loan_monthly_deduc;
                $loanStatus = ($newLoanBalance >= 0) ? Utility::STATUS_ACTIVE : Utility::ZERO ;
                Requisition::defaultUpdate('id',$data->id,['loan_balance' => $newLoanBalance, 'accessible_status' => $loanStatus]);

            }

        }


    }
}
