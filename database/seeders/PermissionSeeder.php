<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate([
            'name' => "Super Admin",
            'guard_name' => "admin",
        ]);
        $data = [
            [
                'name' => 'Dashboard',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'Admins',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'users',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'main_categories',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'categories',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'products',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'boxes',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'gifts',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'offers',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'about_us',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'terms',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'privacy',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'zones',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'settings',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'orders',
                'guard_name' => 'admin',
            ],
            //
        ];
        foreach ($data as $row){
            Permission::updateOrCreate($row);
        }
        $user = Admin::first();
        $user->givePermissionTo(Permission::pluck('name')->toArray());
    }
}
