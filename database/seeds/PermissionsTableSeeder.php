<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'Administer roles & permissions';

        $permission = new Permission();
        $permission->name = $name;
        // $permission->guard_name = 'web';
        $permission->save();
    }
}
