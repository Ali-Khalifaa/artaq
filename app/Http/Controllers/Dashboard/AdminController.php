<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Http\Requests\Dashboard\EmployeeRequest;
use App\Http\Resources\Dashboard\AdminResource;
use App\Models\Admin;
use App\Models\Income;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class AdminController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [];
        return [
            new Middleware('can:admin read', only: ['index']),
            new Middleware('can:admin create', only: ['store']),
            new Middleware('can:admin edit', only: ['update', 'show']),
            new Middleware('can:admin delete', only: ['destroy']),
        ];
    }


    public function all_roles()
    {
        $roles = DB::table('sys_roles')->whereGuardName('admin_api')->whereStatus(1)->whereNotIn('name',['SuperAdmin'])->get();
        return responseJson($roles,'',200);
    }

    public function index(Request $request)
    {
        $admins = Admin::whereRelation('roles','name','!=','SuperAdmin')->searchAndFilter()->latest()->paginate(15);

        return responseJson(AdminResource::collection($admins->items()),'',200,getPaginates($admins));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $data = $request->validated();
        if($request->image)
            $data['image'] = store_single_image($request->image);
        $data['password'] = bcrypt($request->password);
        $admin = Admin::create($data);
        $admin->assignRole($request->input('role_name'));
        return responseJson([],'Created Successfully',200);
    }

    public function edit(Admin $admin)
    {
        $roles = DB::table('sys_roles')->whereGuardName('admin_api')->whereStatus(1)->whereNotIn('name',['SuperAdmin'])->get();
        return responseJson(['admin' => $admin, 'roles' => $roles],'',200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $data = $request->validated();
        if($request->image){
            $data['image'] = store_single_image($request->image);
            if($admin->getAttributes()['image'])
                unlink_image_by_path($admin->getAttributes()['image']);
        }
        if($request->password)
            $data['password'] = bcrypt($request->password);
        $admin->update(collect($data)->filter()->toArray());
        $admin->update(['status'=>$request->status]);

        $admin->assignRole($request->input('role_name'));

        return responseJson([],'Updated Successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        unlink_image_by_path($admin->getAttributes()['image']);
        $admin->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
