<?php

namespace Database\Seeders;

use App\Models\MainCategory;
use Illuminate\Database\Seeder;

class MainCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (MainCategory::count() < 5) {

            MainCategory::create([
                'id' => 1,
                'title_ar' => 'طفل',
                'title_en' => 'Baby',
                'image' => '3.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);

            MainCategory::create([
                'id' => 2,
                'title_ar' => 'ولد',
                'title_en' => 'Boy',
                'image' => '4.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);

            MainCategory::create([
                'id' => 3,
                'title_ar' => 'فتاة',
                'title_en' => 'Girl',
                'image' => '5.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            MainCategory::create([
                'id' => 4,
                'title_ar' => 'رجل',
                'title_en' => 'Man',
                'image' => '6.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);

            MainCategory::create([
                'id' => 5,
                'title_ar' => 'امرأة',
                'title_en' => 'Woman',
                'image' => '3.png',
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
        }




    }
}
