<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminProfileRequest;
use App\Http\Resources\Dashboard\AdminResource;

class ProfileController extends Controller
{


    public function updateAdminProfile(AdminProfileRequest $request)
    {
        $admin = auth()->guard('admin_api')?->user();
        if($admin){
            $data = $request->validated();         
            if($request->image){
                $data['image'] = store_single_image($request->image);
                if($admin->getAttributes()['image'])
                    unlink_image_by_path($admin->getAttributes()['image']);
            }
            if($request->password)
                $data['password'] = bcrypt($request->password);
    
            $admin->update(collect($data)->filter()->toArray());
            return responseJson(New AdminResource($admin),'Updated Successfully',200);           
        }
       
    }

}
