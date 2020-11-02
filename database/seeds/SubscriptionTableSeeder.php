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
            'apps' => '{0,1}',
            'user_count' => '4',
            'app_format' => '{"0":"1","1":"2"}',            
            'active_status' => '0',
            'status' => '1',
        ]);

    }
}
