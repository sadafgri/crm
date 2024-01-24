<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);
        $sellerRole = Role::create(['name' => 'seller']);

        $adminRole->givePermissionTo('all');
        $customerRole->givePermissionTo(['IndexOrders','StoreOrders','DestroyOrders','UpdateOrders']);
        $sellerRole->givePermissionTo(['IndexProducts','StoreProducts','DestroyProducts','UpdateProducts']);
    }
}
