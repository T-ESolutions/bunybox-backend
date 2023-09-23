<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'site_name_ar' => 'ليما',
            'site_name_en' => 'lima',
            'phone' => '8484858845855',
            'email' => 'info@lima.com',
            'logo' => 'uploads/setting/web_logo.png',
            'login_pg' => 'uploads/setting/login_pg.png',
            'logo_login' => 'uploads/setting/login_page_logo.png',
            'location' => "null",
            'address_ar' => 'المنوفية',
            'address_en' => 'al mnofia',
            'app_gif' => "null",
            'android_version' => 1,
            'ios_version' => 1,
            'facebook' => 'https://www.facebook.com/',
            'youtube' => 'https://www.youtube.com/',
            'instagram' => 'https://www.instagram.com/',
            'accessKey' => 'accessKey9A3q9p6V0eKVizqYt9Su9KAMfORbccWrvoJVUCGPKqHBvEgvtJq',
        ];



        Setting::setMany($data);

        Setting::create(['key'=>'slider_image','value'=>'image','image'=>'slider_image.png']);
    }
}
