<?php
namespace App\Http\Actions;

use App\Http\Requests\AwardRequest;
use App\Http\Requests\Blog\AssignRoleRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;
use Spatie\Permission\Traits\HasRoles;


class RolesAndPermissionAction
{
    use HasApiResponses;
    use HasRoles;

    public function  allRoles()
    {
       $role = Role::all();
        return $this->successResponse($role);
    }

    public function  allPermission()
    {
        $permision = Permission::all();
        return $this->successResponse($permision);
    }

    public function Permission(PermissionRequest $request)
    {

        $validation = new PermissionRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());
        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        try {
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        }catch (\Exception $exception){
            return $this->serverErrorAlert($exception);
        }
        return $this->successResponse($permission);

    }


    public function Role(RoleRequest $request): JsonResponse
    {
        $validation = new RoleRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());
        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
        }catch (\Exception $exception){
            return $this->serverErrorAlert($exception);
        }
        return $this->successResponse($role);


    }

    public function assignRole(AssignRoleRequest $id)
    {
        // chang user role from "Customer  to other

        $validation = new AssignRoleRequest(request()->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());
        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user1 = new User;
        $user2 = Auth::user();
        $admin = User::findOrFail($id);
        foreach ($admin  as $sel)
        try {
            if ($sel->id != "99") {
dd($sel->id);
                $sel->syncRoles(request()->role);
                return $this->successResponse('role successfully updated');
            } else {
                return $this->notFoundAlert('role no updated');
            }
        } catch(Exception $exception) {
            return $this->serverErrorAlert('server error', $exception);

        }

    }
    public function assignPermissionToRole(Request $request)
    {
        //Validate name and permissions field
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:40',
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->formValidationErrorAlert($validator->errors());
        }

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();
        //Looping through selected permissions
        foreach ($permissions as $permission) {
            $permit = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($permit);
        }

        return $this->successResponse('Successfully added ' . $role->name . ' role');
    }

    public function updatePermissionToRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        //Validate name and permission fields
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|max:40|unique:roles,name,' . $id,
//            'permissions' => 'required',
//        ]);

//        if ($validator->fails()) {
//            return $this->formValidationErrorAlert($validator->errors());
//        }

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $all_permissions = Permission::all();

        foreach ($all_permissions as $permitted) {
            $role->revokePermissionTo($permitted);
        }

        foreach ($permissions as $permission) {
            $permit = Permission::where('id', '=', $permission)->firstOrFail();
            $role->givePermissionTo($permit);
        }

        return $this->successResponse('Successfully updated ' . $role->name . ' role');
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return $this->successResponse('Successfully deleted the role');
    }

    public function destroyPermission($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return $this->successResponse('Successfully deleted the permission');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:40|unique:permissions',
        ]);

        if ($validator->fails()) {
            return $this->formValidationErrorAlert($validator->errors());
        }

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (! empty($request['roles'])) {
            foreach ($roles as $role) {
                $give_role = Role::where('name', '=', $role)->firstOrFail();

                $permission = Permission::where('name', '=', $name)->first();
                $give_role->givePermissionTo($permission);
            }
        }

        return $this->successResponse('Successfully added ' . $permission->name . ' to the permission table');
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:40|unique:permissions,name,' . $id,
        ]);

        if ($validator->fails()) {
            return $this->formValidationErrorAlert($validator->errors());
        }

        $input = $request->all();
        $permission->fill($input)->save();

        return $this->successResponse('Successfully updated ' . $permission->name . ' in the permission table');
    }



}
