<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $ticket;
    public $comment;

    public function __construct($ticket = [],$comment =[])
    {
        $this->ticket = $ticket;
        $this->comment = $comment;
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
        return 'ticket.action';
    }

    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage(['ticket' =>  $this->ticket,'comment' => $this->comment]))->onConnection('sync');
    }
}
