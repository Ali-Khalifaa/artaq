<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\ChatChannelResource;
use App\Http\Resources\Dashboard\ChatMessageResource;
use App\Models\Admin;
use App\Models\ChatChannel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Driver\Models\Driver;
use Modules\Rest\Models\RestOwner;
use Modules\Showroom\Models\SRShowroom;
use Modules\User\Models\User;

class SendNotificationController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:admin send notification', only: ['sendToAdmin']),
            new Middleware('can:user send notification', only: ['sendToUser']),
            new Middleware('can:driver send notification', only: ['sendToDriver']),
            new Middleware('can:car showroom send notification', only: ['sendToShowroom']),
            new Middleware('can:restaurant send notification', only: ['sendToRestaurant']),
        ];
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'type' => 'required|in:'.Admin::class.','.Driver::class.','.User::class.','.SRShowroom::class.','.RestOwner::class,
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
            case Driver::class:
                $users = $this->sendToDriver();
                break;
            case User::class:
                $users = $this->sendToUser();
                break;
            case SRShowroom::class:
                $users = $this->sendToShowroom();
                break;
            case RestOwner::class:
                $users = $this->sendToRestaurant();
                break;
        }

        sendNotification($users, [],'',asset('assets/images/brand-logos/toggle-white.png'), request()->title, request()->message,[],'dashboard' , request()->expire_date ?? null);

        return responseJson([],'',200);
    }

    public function sendToAdmin()
    {
        return request()->to == 'all'? Admin::where('id','!=',auth('admin_api')->user()?->id)->get():Admin::findOrFail(request()->to);
    }
    public function sendToUser()
    {
        return request()->to == 'all'? User::get():User::findOrFail(request()->to);
    }
    public function sendToDriver()
    {
        return request()->to == 'all'? Driver::get():Driver::findOrFail(request()->to);
    }
    public function sendToShowroom()
    {
        return request()->to == 'all'? SRShowroom::get():SRShowroom::findOrFail(request()->to);
    }
    public function sendToRestaurant()
    {
        return request()->to == 'all'? RestOwner::get():RestOwner::findOrFail(request()->to);
    }

}
