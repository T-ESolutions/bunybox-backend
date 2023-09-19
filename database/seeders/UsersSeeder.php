<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('phone', '505505050')->first()) {
            User::create([
                'name' => 'customer 1',
                'phone' => '505505050',
                'email' => 'user@gmail.com',
                'password' => '123456',
                'email_verified_at' => Carbon::now(),
                'weight' => '90',
                'height' => '180',
                'age' => '28',
                'shoes_size' => '45',
                'size' => 'XL',
            ]);
        }
    }
}
