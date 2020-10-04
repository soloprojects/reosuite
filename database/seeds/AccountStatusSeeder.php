<?php

use Illuminate\Database\Seeder;
use App\model\AccountStatus;

class AccountStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AccountStatus::create([
            'name' => 'Open',
            'status' => '1',
        ]);

        AccountStatus::create([
            'name' => 'Closed',
            'status' => '2',
        ]);


    }
}
