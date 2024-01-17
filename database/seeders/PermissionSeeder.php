<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'filter users']);
        Permission::create(['name' => 'index users']);
        Permission::create(['name' => 'store users']);
        Permission::create(['name' => 'destroy users']);
        Permission::create(['name' => 'update users']);

        Permission::create(['name' => 'filter products']);
        Permission::create(['name' => 'index products']);
        Permission::create(['name' => 'store products']);
        Permission::create(['name' => 'destroy products']);
        Permission::create(['name' => 'update products']);

        Permission::create(['name' => 'filter orders']);
        Permission::create(['name' => 'index orders']);
        Permission::create(['name' => 'store orders']);
        Permission::create(['name' => 'destroy orders']);
        Permission::create(['name' => 'update orders']);

        Permission::create(['name' => 'filter checks']);
        Permission::create(['name' => 'index checks']);
        Permission::create(['name' => 'store checks']);
        Permission::create(['name' => 'destroy checks']);
        Permission::create(['name' => 'update checks']);
    }
}
