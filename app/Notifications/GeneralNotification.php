<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;


    protected $title,$message,$sourceable_id,$sourceable_type,$web_link;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link)
    {
        $this->title = $title;
        $this->message = $message;
        $this->sourceable_id = $sourceable_id;
        $this->sourceable_type = $sourceable_type;
        $this->web_link = $web_link;
        $this->deep_link = $deep_link;
      
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function todatabase($notifiable)
    {
        return [
            'title'=>$this->title,
            'message'=>$this->message,
            'sourceable_id'=>$this->sourceable_id,
            'sourceable_type'=>$this->sourceable_type,
            'web_link'=>$this->web_link,
        ];
    }
}
