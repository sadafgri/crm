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
        Permission::create(['name' => 'FilterUsers']);
        Permission::create(['name' => 'IndexUsers']);
        Permission::create(['name' => 'StoreUsers']);
        Permission::create(['name' => 'DestroyUsers']);
        Permission::create(['name' => 'UpdateUsers']);

        Permission::create(['name' => 'FilterProducts']);
        Permission::create(['name' => 'IndexProducts']);
        Permission::create(['name' => 'StoreProducts']);
        Permission::create(['name' => 'DestroyProducts']);
        Permission::create(['name' => 'UpdateProducts']);

        Permission::create(['name' => 'FilterOrders']);
        Permission::create(['name' => 'IndexOrders']);
        Permission::create(['name' => 'StoreOrders']);
        Permission::create(['name' => 'DestroyOrders']);
        Permission::create(['name' => 'UpdateOrders']);

        Permission::create(['name' => 'FilterChecks']);
        Permission::create(['name' => 'IndexChecks']);
        Permission::create(['name' => 'StoreChecks']);
        Permission::create(['name' => 'DestroyChecks']);
        Permission::create(['name' => 'UpdateChecks']);
    }
}
