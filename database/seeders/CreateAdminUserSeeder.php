<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Fazle',
            'email' => 'admin@demo.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'user']);
        $permissions = [
            'post-list',
            'post-create',
            'post-edit',
            'post-delete'
            ];
        $role2->syncPermissions($permissions);
        Category::create(['name' => 'Vue.js']);
        Category::create(['name' => 'Cat 2']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
