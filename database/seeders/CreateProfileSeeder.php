<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;

class CreateProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '09000000000',
                'address' => 'Yangon',
            ],
            [
                'name' => 'Tin Naing Htun',
                'email' => 'tnh@gmail.com',
                'phone' => '09000000000',
                'address' => 'Yangon',
            ],
            [
                'name' => 'Su Mi',
                'email' => 'sm@gmail.com',
                'phone' => '09000000000',
                'address' => 'Yangon',
            ],
        ];

        DB::table('user_profiles')->truncate();
        foreach ($profile as $key => $value) {
            UserProfile::create($value);
        }
    }
}
