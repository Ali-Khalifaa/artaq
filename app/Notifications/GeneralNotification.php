<?php

namespace App\Notifications;

use Hamcrest\Arrays\IsArray;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Modules\User\Models\User;
use Modules\Driver\Models\Driver;

class GeneralNotification extends Notification implements ShouldBroadcast
{

    public $data;
    public $pageVueName;
    public $title;
    public $message;
    public $variables;
    public $image;
    public $expire_date;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data = [],$pageVueName = '',$image='',$title='',$message='',$variables=[],$type=null,$expire_date=null)
    {
        $this->data = $data;
        $this->pageVueName = $pageVueName;
        $this->title = $title;
        $this->message = $message;
        $this->variables = $variables;
        $this->image = $image;
        $this->expire_date = $expire_date;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $title = $this->title;
        $message = $this->message;
        if(is_array($this->title) && !($notifiable instanceof User) && !($notifiable instanceof Driver)){
            $title = $this->title['ar'];
            $message = $this->message['ar'];
        }

        return [
            'timeDate' => now()->format('Y-m-d H:i'),
            'page_vue_name' => $this->pageVueName,
            'id' => $this->data ? (is_array($this->data) ? $this->data['id']:$this->data?->id) : 0,
            'message' => $message,
            'title' => $title,
            'variables' => $this->variables,
            'data' => is_array($this->data) && count($this->data) == 0? ['id' => 0]:$this->data,
            'image' => $this->image,
            'type' => $this->type,
            'expire_date' => $this->expire_date,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $title = $this->title;
        $message = $this->message;
        if(is_array($this->title)){
            if(($notifiable instanceof User || $notifiable instanceof Driver)){
                $title = $this->title[$notifiable->language] ?? $this->title['en'];
                $message = $this->message[$notifiable->language] ?? $this->message['en'];
            }else{
                $title = $this->title['ar'];
                $message = $this->message['ar'];
            }
        }else{
            if(($notifiable instanceof User || $notifiable instanceof Driver)){
                $title = __("notifications.$title",$this->variables,$notifiable->language);
                $message = __("notifications.$message",$this->variables,$notifiable->language);
            }else{
                $title = __("notifications.$title",$this->variables,"ar");
                $message = __("notifications.$message",$this->variables,"ar");
            }
        }

        return (new BroadcastMessage([
            'data' => [
                'timeDate' => now()->format('Y-m-d H:i'),
                'page_vue_name' => $this->pageVueName,
                'message' => $message,
                'title' => $title,
                'id' => $this->data ? (is_array($this->data) ? $this->data['id']:$this->data?->id) : 0,
                'data' => is_array($this->data) && count($this->data) == 0? ['id' => 0]:$this->data,
                'image' => $this->image,
            ]
        ]))->onConnection('sync');
    }
}
