<?php
namespace App\Http\Actions;

use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;

class PermissionsAction
{
    use HasApiResponses;
    public function execute(Request $request): JsonResponse
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
