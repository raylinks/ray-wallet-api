<?php
namespace App\Http\Actions;

use App\Http\Requests\AwardRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;

class RolesAndPermissionAction
{
    use HasApiResponses;

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

    public function assignPermission(): JsonResponse
    {

        $role = Role::findById(1);
        $permission = Permission::findById(1);
        //A permission can be assigned to a role:
        $role->givePermissionTo($permission);


        return JSON(200, $role->toArray(), 'Roles And permission Created');
    }
}
