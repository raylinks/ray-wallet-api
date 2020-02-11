<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Actions\PermissionsAction;
use App\Http\Actions\RolesActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\User;

class PermissionsController extends Controller
{

    use Notifiable;
    use HasRoles;

    public function createRole(Request $request)
    {
//dd('international');

        return (new PermissionsAction())->execute();
    }


    public function createPermission(){
        $permission = Permission::create(['name' => 'build mockup']);
        return JSON(200, $permission->toArray(), ' permission Created');


    }

    public function getAllRoles(){
        $roles = Role::all();
        return JSON(200, $roles->toArray(), ' Role Created');
    }


    public function assignPermissionToRole(){
        return (new PermissionsAction())->assign();
    }


    public function  get(Request $request ,$user){

    }
}
