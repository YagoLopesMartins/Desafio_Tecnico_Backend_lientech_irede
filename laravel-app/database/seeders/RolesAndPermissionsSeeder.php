<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $viewProducts = Permission::create(['name' => 'view-products']);
        $createProducts = Permission::create(['name' => 'create-products']);
        $editProducts = Permission::create(['name' => 'edit-products']);
        $deleteProducts = Permission::create(['name' => 'delete-products']);

        $adminRole->permissions()->attach([$viewProducts->id, $createProducts->id, $editProducts->id, $deleteProducts->id]);
        $userRole->permissions()->attach([$viewProducts->id]);
    }
}
