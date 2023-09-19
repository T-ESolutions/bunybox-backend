<?php

use Database\Seeders\AdminSeeder;
use Database\Seeders\BoxSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\MainCategorySeed;
use Database\Seeders\PagesSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminSeeder::class);
         $this->call(MainCategorySeed::class);
         $this->call(CategorySeeder::class);
         $this->call(BoxSeeder::class);
         $this->call(PagesSeeder::class);
         $this->call(SettingsSeeder::class);
         $this->call(UsersSeeder::class);
    }
}
