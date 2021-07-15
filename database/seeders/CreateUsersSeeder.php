<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
               'password'=> bcrypt('1234'),
               'profile'=>'profile.png',
               'type'=>0,
               'phone'=>'09000000000',
               'address'=>'Yangon',
               'dob'=>'1998-05-01',
               'created_user_id' => 1,
                'updated_user_id' => 1,
            ],
            [
                'name'=>'Tin Naing Htun',
                'email'=>'tnh@gmail.com',
                'password'=> bcrypt('1234'),
                'profile'=>'profile.png',
                'type'=>0,
                'phone'=>'09000000011',
                'address'=>'Yangon',
                'dob'=>'1998-05-01',
                'created_user_id' => 1,
                 'updated_user_id' => 1,
             ],
             [
                'name'=>'Su Mi',
                'email'=>'sm@gmail.com',
                'password'=> bcrypt('1234'),
                'profile'=>'profile.png',
                'type'=>0,
                'phone'=>'09000000001',
                'address'=>'Yangon',
                'dob'=>'1998-05-01',
                'created_user_id' => 1,
                 'updated_user_id' => 1,
             ],
        ];
        
        DB::table('user_profiles')->truncate();
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
