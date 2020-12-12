<?php

use App\model\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Subscription::create([
            'apps' => '{"0","1"}',
            'user_count' => '1',
            'app_format' => '{"0":"1","1":"2","2":"3","3":"4","4":"5","5":"6","6":"7","7":"8","8":"9","9":"10","10":"11","11":"12","12":"13","13":"14","14":"15","15":"16","16":"17","17":"18","18":"19"}',            
            'active_status' => '0',
            'status' => '1',
        ]);

    }
}
