<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@paremape.com',
            'password' => Hash::make('admin@123'),
            'decoded_password' => 'admin@123',
            'admin_type' => 'Super-Admin',
        ]);
    }
}
