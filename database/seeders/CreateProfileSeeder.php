<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfile;

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
                'image' => 'profile.jpg',
                'phone' => '09000000000',
                'address' => 'Yangon',
            ],
            [
                'name' => 'Tin Naing Htun',
                'email' => 'tnh@gmail.com',
                'image' => 'profile.jpg',
                'phone' => '09000000000',
                'address' => 'Yangon',
            ],
            [
                'name' => 'Su Mi',
                'email' => 'sm@gmail.com',
                'image' => 'profile.jpg',
                'phone' => '09000000000',
                'address' => 'Yangon',
            ],
        ];

        foreach ($profile as $key => $value) {
            UserProfile::create($value);
        }
    }
}
