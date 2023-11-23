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
            'site_name_ar' => 'بني بوكس',
            'site_name_en' => 'Bunny Box',
            'phone' => '8484858845855',
            'email' => 'info@lima.com',
            'location' => "null",
            'address_ar' => 'المنوفية',
            'address_en' => 'al mnofia',
//            'app_gif' => "null",
            'android_version' => 1,
            'ios_version' => 1,
            'facebook' => 'https://www.facebook.com/',
            'youtube' => 'https://www.youtube.com/',
            'instagram' => 'https://www.instagram.com/',
            'accessKey' => 'accessKey9A3q9p6V0eKVizqYt9Su9KAMfORbccWrvoJVUCGPKqHBvEgvtJq',
            'in_riyadh_shipping_cost' => 0,
            'out_riyadh_shipping_cost' => 25,
            'money_gifts' => 2,
            'product_gifts' => 4,
        ];



        Setting::setMany($data);

        Setting::create(['key'=>'fav_icon','value'=>'image','image'=>'fav_icon.png']);
        Setting::create(['key'=>'logo','value'=>'image','image'=>'web_logo.png']);
        Setting::create(['key'=>'logo_login','value'=>'image','image'=>'login_page_logo.png']);
        Setting::create(['key'=>'slider_image','value'=>'image','image'=>'slider_image.png']);
        Setting::create(['key'=>'gift_money_image','value'=>'image','image'=>'gift_money_image.png']);
    }
}
