<?php

namespace App\Http\Controllers\Api;
use App\Http\Actions\RolesAndPermissionAction;
use App\Http\Requests\Blog\AssignRoleRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;

class RolesAndPermissionController extends Controller
{

    public  function index()
    {
        return(new RolesAndPermissionAction())->allRoles();

    }

    public  function allPermisson()
    {
        return(new RolesAndPermissionAction())->allPermission();

    }

    public  function createRole(Request $request)
    {
        return(new RolesAndPermissionAction())->Role(
            new RoleRequest($request->all())
        );

    }

    public  function createPermission(Request $request)
    {
        return(new RolesAndPermissionAction())->Permission(
            new PermissionRequest($request->all())
        );

    }

    public  function updateRole($id)
    {
        return(new RolesAndPermissionAction())->assignRole(
            new AssignRoleRequest($id)
        );

    }

    public  function assignPermission(Request $request)
    {
        return(new RolesAndPermissionAction())->assignPermissionToRole();


    }
    public  function updatePermissionToRole( $id)
    {
    return(new RolesAndPermissionAction())->updatePermissionToRole($id);

    }

    public  function DeleteRole($id)
    {
        return(new RolesAndPermissionAction())->destroyRole($id);

    }

    public  function DeletePermission($id)
    {
        return(new RolesAndPermissionAction())->destroyPermission($id);

    }

    public  function postUpdatePermission(Request $request ,$id)
    {
        return(new RolesAndPermissionAction())->updatePermission($id);

    }

}
