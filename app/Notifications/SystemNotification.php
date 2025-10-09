<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    public $type;       // 'job_applied', 'job_posted', 'job_approved', 'message_received'
    public $data;       // array with details

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database']; // store in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
        ];
    }
}