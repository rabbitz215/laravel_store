<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'add products']);
        Permission::create(['name' => 'list category']);
        Permission::create(['name' => 'add category']);
        Permission::create(['name' => 'list users']);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ])->givePermissionTo(Permission::all());

        Role::create([
            'name' => 'moderator',
            'guard_name' => 'web'
        ])->givePermissionTo(['list products', 'list category']);

        Role::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);
    }
}
