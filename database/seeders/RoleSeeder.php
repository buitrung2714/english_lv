<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Staff;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::truncate();

        Staff::create([
            'staff_name'        =>  'Admin',
            'staff_email'       =>  'admin@gmail.com',
            'staff_password'    =>   md5('123456'),
        ]);
        Staff::create([
            'staff_name'        =>  'Teacher',
            'staff_email'       =>  'teacher@gmail.com',
            'staff_password'    =>   md5('123456'),
        ]);
        Role::create(['role_name'=>'Admin']);
        Role::create(['role_name'=>'User']);
        Role::create(['role_name'=>'Teacher']);
    }
}
