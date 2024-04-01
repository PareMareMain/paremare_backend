<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [[
            'amount' => "100",
            'plan_type' => 3,
            'name' => 'Yearly',
            'status' => 1,
            'type' => 0,
        
        ],[
            'amount' => "60",
            'plan_type' => 2,
            'name' => 'Monthly',
            'status' => 0,
            'type' => 0,

        
        ],[
            'amount' => "30",
            'plan_type' => 1,
            'name' => 'Daily',
            'status' => 0,
            'type' => 0,
        ],[
            'amount' => "100",
            'plan_type' => 3,
            'name' => 'Yearly',
            'status' => 1,
            'type' => 1,
        
        ],[
            'amount' => "60",
            'plan_type' => 2,
            'name' => 'Monthly',
            'status' => 0,
            'type' => 1,

        
        ],[
            'amount' => "30",
            'plan_type' => 1,
            'name' => 'Daily',
            'status' => 0,
            'type' => 1,
        ]];
        foreach ($data as $key => $value) {
            Subscription::create($value);
        }
        
    }
}
