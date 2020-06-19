<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'customer';

        $role = new Role();
        $role->name = $name;
        // $role->guard_name = 'web';
        $role->save();

        $permissionName = 'Administer roles & permissions';
        $permission = Permission::where('name', '=', $permissionName)->firstOrFail();

        $addRole = Role::where('name', '=', $name)->first();
        $addRole->givePermissionTo($permission);
    }
}
