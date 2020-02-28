<?php
namespace App\Http\Actions;

use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;

class RolesActions
{
    use HasApiResponses;

    public function execute(Request $request)
    {
        $role = Role::find($request->id);
      //  $permission = Permission::create(['name' => 'edit articles']);
       // $role->givePermissionTo($permission);
      //  $role->givePermissionTo($permission);

        //$role = Role::findById($request->id);
        $permission = Permission::findById($request->id);
        //A permission can be assigned to a role using 1 of these methods:
        $role->givePermissionTo($permission);

        return JSON(200, $role->toArray(), 'Roles And permission Created');

    }

}
