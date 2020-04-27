<?php
namespace App\Http\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;

class RolesAndPermissionAction
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


    public function executek(Request $request): JsonResponse
    {
        $role = Role::create(['name' => 'Graphics']);
        return JSON(200, $role->toArray(), 'Roles Created');


    }

    public function assign(): JsonResponse
    {
        // dd("love");
        $role = Role::findById(1);
        $permission = Permission::findById(1);
        //A permission can be assigned to a role:
        $role->givePermissionTo($permission);


        return JSON(200, $role->toArray(), 'Roles And permission Created');
    }
}
