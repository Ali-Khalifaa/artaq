<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TrackUserBookingNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $lat;
    public $lng;

    public function __construct($lat = '',$lng =[])
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }


    public function broadcastAs(): string
    {
        return 'move';
    }

    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage(['lat' =>  $this->lat,'lng' => $this->lng]))->onConnection('sync');
    }
}
