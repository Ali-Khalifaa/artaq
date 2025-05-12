<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\NotificationResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getAllNot(Request $request)
    {
        $count = 15;
        $skip = 0;

        if($request->skip){
            $skip = $request->skip;
        }

        $Notifications = auth()->guard('admin_api')->user()->notifications()->latest()->skip($skip)->limit($count)->get();
        $NotificationsCount = auth()->guard('admin_api')->user()->notifications->count();

        return responseJson(['notifications' => NotificationResource::collection($Notifications),'count' => $NotificationsCount],'',200);

    }

    public function getNotNotRead()
    {
        $user = auth()->guard('admin_api')->user();
        $Notifications = $user->unreadNotifications;
        $NotificationsCount = $Notifications->count();
        return responseJson(['notifications' => NotificationResource::collection($Notifications),'count' => $NotificationsCount],'',200);

    }

    public function clearItem($id)
    {

        auth()->guard('admin_api')->user()->notifications()->where('id', $id)->update(['read_at' => now()]);

        return responseJson([],'Data exited successfully',200);
    }

    public function clearAll()
    {
        $user = auth()->guard('admin_api')->user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return responseJson([],'Data exited successfully',200);
    }

}
