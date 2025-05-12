<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingRequestNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $title;
    public $data;

    public function __construct($title = '',$data =[])
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }


    public function broadcastAs(): string
    {
        return 'booking.request';
    }

    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage(['title' =>  $this->title,'data' => $this->data,'image' => asset('assets/images/brand-logos/toggle-white.png')]))->onConnection('sync');
    }
}
