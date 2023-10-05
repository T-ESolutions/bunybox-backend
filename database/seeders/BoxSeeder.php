<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\BoxCategory;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Box::count() < 3) {
            //box 1
            Box::create([
                'id' => 1,
                'title_ar' => 'صندوق ب300',
                'title_en' => 'Box with 300',
                'image' => 'box.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',

                "price" => 300,
                "min_price" => 300,
                "max_price" => 320,
                "main_category_id" => 1,
                "is_offer" => 0,
                "offer_end_time" => null,
                "offer_price" => 0,
            ]);

            BoxCategory::create([
                'box_id' => 1,
                'category_id' => 1
            ]);
            BoxCategory::create([
                'box_id' => 1,
                'category_id' => 2
            ]);
            BoxCategory::create([
                'box_id' => 1,
                'category_id' => 3
            ]);
            BoxCategory::create([
                'box_id' => 1,
                'category_id' => 4
            ]);
            BoxCategory::create([
                'box_id' => 1,
                'category_id' => 5
            ]);
            BoxCategory::create([
                'box_id' => 1,
                'category_id' => 6
            ]);

            //box 2
            Box::create([
                'id' => 2,
                'title_ar' => 'صندوق ب400',
                'title_en' => 'Box with 400',
                'image' => 'box.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',

                "price" => 400,
                "min_price" => 400,
                "max_price" => 440,
                "main_category_id" => 1,
                "is_offer" => 0,
                "offer_end_time" => null,
                "offer_price" => 0,
            ]);

            BoxCategory::create([
                'box_id' => 2,
                'category_id' => 1
            ]);
            BoxCategory::create([
                'box_id' => 2,
                'category_id' => 2
            ]);
            BoxCategory::create([
                'box_id' => 2,
                'category_id' => 3
            ]);
            BoxCategory::create([
                'box_id' => 2,
                'category_id' => 7
            ]);
            BoxCategory::create([
                'box_id' => 2,
                'category_id' => 8
            ]);
            BoxCategory::create([
                'box_id' => 2,
                'category_id' => 9
            ]);

            //box 3
            Box::create([
                'id' => 3,
                'title_ar' => 'صندوق ب500',
                'title_en' => 'Box with 500',
                'image' => 'box.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',

                "price" => 500,
                "min_price" => 500,
                "max_price" => 550,
                "main_category_id" => 1,
                "is_offer" => 0,
                "offer_end_time" => null,
                "offer_price" => 0,
            ]);

            BoxCategory::create([
                'box_id' => 3,
                'category_id' => 4
            ]);
            BoxCategory::create([
                'box_id' => 3,
                'category_id' => 5
            ]);
            BoxCategory::create([
                'box_id' => 3,
                'category_id' => 6
            ]);
            BoxCategory::create([
                'box_id' => 3,
                'category_id' => 7
            ]);
            BoxCategory::create([
                'box_id' => 3,
                'category_id' => 8
            ]);
            BoxCategory::create([
                'box_id' => 3,
                'category_id' => 9
            ]);
        }
    }
}
