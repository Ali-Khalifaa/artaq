<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\NotificationResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

   public function getAllNot()
    {
        $user = auth()->guard("student_api")->user();
        $Notifications = $user->notifications()->orderBy('read_at', 'desc')->latest()->paginate(15);
        return responseJson(['notifications' =>NotificationResource::collection($Notifications->items()),'unread_notifications_count' => $user->unreadNotifications->count()],'',200,getPaginates($Notifications));
    }

    public function getNotReadNotifications()
    {
        $user = auth()->guard("student_api")->user();
        return responseJson(['notifications' => NotificationResource::collection($user->unreadNotifications),'unread_notifications_count' => $user->unreadNotifications->count()]);
    }

    public function clearItem($id)
    {
        auth()->guard("student_api")->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return responseJson(null,__('translations.Cleared Successfully'));
    }

    public function clearAll()
    {
        $user = auth()->guard("student_api")->user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return responseJson(null,__('translations.Cleared Successfully'));
    }


    public function deleteItem($id)
    {
        auth()->guard("student_api")->user()->notifications()->where('id', $id)->delete();
        return responseJson(null,__('translations.Deleted Successfully'));
    }

    public function deleteAll()
    {
        $user = auth()->guard("student_api")->user();
        $user->notifications()->delete();
        return responseJson(null,__('translations.Deleted Successfully'));
    }



}
