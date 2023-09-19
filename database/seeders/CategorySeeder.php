<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Category::count() < 9) {

            Category::create([
                'id' => 1,
                'title_ar' => 'موسيقى',
                'title_en' => 'Music',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 2,
                'title_ar' => 'أزياء وموضة',
                'title_en' => 'Fashion',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 3,
                'title_ar' => 'الكترونيات',
                'title_en' => 'Electronics',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 4,
                'title_ar' => 'الرياضة واللياقة',
                'title_en' => 'Sports & Fitness',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 5,
                'title_ar' => 'المنزل والأثاث',
                'title_en' => 'Home and Furniture',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 6,
                'title_ar' => 'المجوهرات والإكسسوارات',
                'title_en' => 'Jewelry and Accessories',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 7,
                'title_ar' => 'الجمال والعناية الشخصية',
                'title_en' => 'Beauty and Personal Care',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 8,
                'title_ar' => 'الكتب ووسائل الإعلام',
                'title_en' => 'Books & Media',
                'image' => null,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
            ]);
            Category::create([
                'id' => 9,
                'title_ar' => 'الألعاب ',
                'title_en' => 'Toys',
                'image' => null,
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
