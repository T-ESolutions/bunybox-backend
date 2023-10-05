<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\BoxProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (Box::where('is_offer',1)->count() < 10) {
            //box 1
            for($i = 1; $i < 11; $i++) {
                $box = Box::create([
                    'title_ar' => 'صندوق عرض  '.$i,
                    'title_en' => 'offer box '.$i,
                    'image' => 'offer_box.png',
                    'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                    'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
                    "is_offer" => 1,
                    "offer_end_time" => Carbon::now()->addDays(25),
                    "offer_price" => 300,
                ]);
                $products = Product::get();
                if ($products) {
                    foreach ($products as $product) {
                        BoxProduct::create([
                            'box_id' => $box->id,
                            'product_id' => $product->id
                        ]);
                    }
                }
            }

        }
    }
}
