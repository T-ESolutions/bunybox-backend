<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::get();
        if ($categories) {
            if (Product::count() < 10) {
                foreach ($categories as $category) {

                    for ($i = 1; $i < 11; $i++) {
                        Product::create([
                            'title_ar' => 'منتج ' . $category->title . ' رقم ' . $i,
                            'title_en' => 'product ' . $category->title . ' num ' . $i,
                            'image' => null,
                            'quantity' => $i + 5,
                            'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                            'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
                            "category_id" => $category->id,
                            "shoes_size" => null,
                            "size" => 'S',
                            "min_age" => 15,
                            "max_age" => 17,
                            "min_weight" => 50,
                            "max_weight" => 60,
                            "min_height" => 150,
                            "max_height" => 160,

                        ]);
                    }
                }
            }
        }
    }
}
