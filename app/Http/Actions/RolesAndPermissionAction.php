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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;
use Spatie\Permission\Traits\HasRoles;


class RolesAndPermissionAction
{
    use HasApiResponses;
    use HasRoles;

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
        $validation = new AssignRoleRequest(request()->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());
        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user1 = new User;
        $user2 = Auth::user();
        $admin = User::findOrFail($id);
        try {
            if ($admin->id != $user2->id) {
                $user1->syncRoles(request()->role);
                return $this->successResponse('role successfully updated');
            } else {
                return $this->notFoundAlert('role no updated');
            }
        } catch (\Exception $e) {
            return $this->serverErrorAlert('server error');
        }

    }

    public function assignPermissionToRole($id): JsonResponse
    {
        $role = new User();
        request()->validate(['permission' => 'required|string', 'role' => 'required']);
        $permission = strtolower(request()->permission);


        $role = Role::findOrFail(request()->role);
        try {
            if(request()->grant_privelege){
                $p_name = $permission;
            }else{
                $p_name = $role->name . '.' . $permission;
            }

            if(!$permission = Permission::where('name', $p_name)->first()){
                $permission = Permission::create(['name' => $p_name, 'guard_name' => 'web']);
            }
            if($role->hasPermissionTo($p_name))
            {
                $message = ['status' => 'info', 'message' => $role->name . ' already have ' . $permission->name . ' permission.'];
            }else{
                $role->givePermissionTo($permission->id);
                $message = ['status' => 'success', 'message' => 'new permission successfully added'];
            }
        } catch (Exception $e) {
            $message = ['status' => 'warning', 'message' => 'new permission not added'];
        }
        return redirect()->back()->with($message);

    }
}
