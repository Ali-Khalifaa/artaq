<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class RoleController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:role read', only: ['index']),
            new Middleware('can:role create', only: ['store','create']),
            new Middleware('can:role edit', only: ['update', 'edit']),
            new Middleware('can:role delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $roles = Role::select('name', 'id','status')->where('guard_name','admin_api')->whereNotIn('name',['SuperAdmin'])->with('permissions:name')
        ->where(function ($q) use ($request) {
            $search = json_decode(request()->search);
            $searchKey = $search?->searchKey;
            $q->when($searchKey, function ($q) use ($searchKey) {
                $q->where('name', 'like', "%$searchKey%")
                    ->orWhereRelation('permissions', 'name', "%$searchKey%");
            });
        })->latest()->paginate(10);
        return responseJson($roles->items(),'',200,getPaginates($roles));
    }


    public function create()
    {
        $permission = Permission::where('guard_name','admin_api')->get()->groupBy('category')->sortKeys();
        return responseJson(['permission' => $permission],'',200);
    }


    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name,'status' => $request->status,'guard_name' => 'admin_api']);
        $role->syncPermissions($request->input('permission'));
        return responseJson([],'Created Successfully',200);

    }


    public function edit(Role $role)
    {
        $permission = Permission::where('guard_name','admin_api')->get()->groupBy('category')->sortKeys();

        $rolePermissions = DB::table("sys_role_has_permissions")
            ->where("sys_role_has_permissions.role_id", $role->id)->pluck('sys_role_has_permissions.permission_id', 'sys_role_has_permissions.permission_id')->all();

        return responseJson(['notifyRole' => [], 'role' => $role,'notifies' => [], 'permission' => $permission, 'rolePermissions' => $rolePermissions],'',200);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name,'status' => $request->status]);
        $role->syncPermissions($request->input('permission'));
        return responseJson([],'Updated Successfully',200);
    }

    public function destroy(Role $role)
    {
        if (count($role->users) == 0) {
            DB::table("sys_roles")->where('id', $role->id)->delete();
            return responseJson([],'Deleted Successfully',200);
        }
        return responseJson([],'Cant Delete This Role',404);
    }
}

