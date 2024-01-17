<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $customerRole->givePermissionTo('index orders','store orders','destroy orders','update orders');
        $sellerRole->givePermissionTo('index products','store products','destroy products','update products');
    }
}
