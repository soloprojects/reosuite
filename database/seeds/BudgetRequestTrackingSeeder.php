<?php

use Illuminate\Database\Seeder;
use App\model\BudgetRequestTracking;

class BudgetRequestTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $array = ['Monthly','Quarterly','Half Year','Yearly','Monthly Category','Quarterly Category',
            'Half Year Category','Yearly Category'];

        foreach($array as $value){
            BudgetRequestTracking::create([
                'name' => $value,
                'active_status' => '0',
                'status' => '1',
            ]);
        }

    }
}
