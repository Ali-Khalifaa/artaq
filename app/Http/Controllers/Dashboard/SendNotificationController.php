<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SendNotificationController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:admin send notification', only: ['sendToAdmin']),
            new Middleware('can:student send notification', only: ['sendToStudent']),
        ];
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'type' => 'required|in:'.Admin::class.','.Student::class,
            'title' => 'required',
            'message' => 'required',
            'to' => 'required',
            'expire_date' => 'nullable|date|after:yesterday',
        ]);

        $users = [];
        switch ($request->type) {
            case Admin::class:
                $users = $this->sendToAdmin();
                break;
            case Student::class:
                $users = $this->sendToStudent();
                break;
        }

        sendNotification($users, [],'',asset('assets/images/brand-logos/toggle-white.png'), request()->title, request()->message,[],'dashboard' , request()->expire_date ?? null);

        return responseJson([],'',200);
    }

    public function sendToAdmin()
    {
        return request()->to == 'all'? Admin::where('id','!=',auth('admin_api')->user()?->id)->get():Admin::findOrFail(request()->to);
    }
    public function sendToStudent()
    {
        return request()->to == 'all'? Student::get():Student::findOrFail(request()->to);
    }

}
