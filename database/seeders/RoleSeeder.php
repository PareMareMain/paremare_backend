<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=['user','vendor'];
        foreach($role as $key=>$value){
            DB::table('roles')->insert([
                'name' => $value,
                'guard_name' => 'web',
            ]);
        }

    }
}
