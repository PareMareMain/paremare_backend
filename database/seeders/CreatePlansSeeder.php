<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class CreatePlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'name' => "Basic Plan",
            'slug' => "basic_plan",
            'stripe_plan' => 'price_1Nia0kLLicptMIeo3nVHEuKy',
            'plan_type' => 'monthy',
            'plan_days' => '',
            'price' => 10,
            'description' =>"Basic Plan",
        
        ],[
            'name' => "Premium Plan",
            'slug' => "premium_plan",
            'stripe_plan' => 'price_1Nia1eLLicptMIeoEJCILl4l',
            'plan_type' => 'monthy',
            'plan_days' => '',
            'price' => 20,
            'description' =>"Premium Plan",
        
        ]];
        foreach ($data as $key => $value) {
            Plan::create($value);
        }
    }
}
