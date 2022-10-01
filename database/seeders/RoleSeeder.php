<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = DB::table('roles')->insert(['name' => 'Administrator']);
        $admin->permissions()->attach(Permission::pluck('id'));

        $editor = DB::table('roles')->insert(['name' => 'Editor']);
        $editor->permissions()->attach(
            Permission::where('name', '!=', 'posts.delete')->pluck('id')
        );
    }
}
