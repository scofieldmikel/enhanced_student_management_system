<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $user = User::create([
            'name'          => 'Admin',
            'email'         => 'admin@mail.com',
            'password'      => bcrypt('scofield.mike'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user->assignRole('Admin');

        $user2 = User::create([
            'name'          => 'Teacher',
            'email'         => 'teacher@mail.com',
            'password'      => bcrypt('scofield.mike'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user2->assignRole('Teacher');

        $user3 = User::create([
            'name'          => 'Parent',
            'email'         => 'parent@mail.com',
            'password'      => bcrypt('scofield.mike'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user3->assignRole('Parent');

        $user4 = User::create([
            'name'          => 'Student',
            'email'         => 'student@mail.com',
            'password'      => bcrypt('scofield.mike'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user4->assignRole('Student');


        DB::table('teachers')->insert([
            [
                'user_id'           => $user2->id,
                'gender'            => 'male',
                'phone'             => '6969540014',
                'dateofbirth'       => '1990-04-11',
                'current_address'   => '45, Bagidan, Ikorodu',
                'permanent_address' => '45, Estate Ikorodu',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

        DB::table('parents')->insert([
            [
                'user_id'           => $user3->id,
                'gender'            => 'male',
                'phone'             => '0147854545',
                'current_address'   => '46 Cogress Street',
                'permanent_address' => '46 Cogress Street',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

        DB::table('grades')->insert([
            'teacher_id'        => 1,
            'class_numeric'     => 1,
            'class_name'        => 'JSS One',
            'class_description' => 'Junior Secondary School One'
        ]);

        DB::table('students')->insert([
            [
                'user_id'           => $user4->id,
                'parent_id'         => 1,
                'class_id'          => 1,
                'roll_number'       => 1,
                'gender'            => 'male',
                'phone'             => '7801256654',
                'dateofbirth'       => '2007-04-11',
                'current_address'   => '103 Pine Tree Lane',
                'permanent_address' => '103 Pine Tree Lane',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

    }
}
