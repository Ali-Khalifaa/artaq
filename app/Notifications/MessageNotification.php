<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }


    public function broadcastAs(): string
    {
        return 'message.created';
    }
    
    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage(['data' =>  $this->data]))->onConnection('sync');
    }
}
