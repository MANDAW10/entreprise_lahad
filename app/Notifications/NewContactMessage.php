<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\ContactMessage;

class NewContactMessage extends Notification
{
    use Queueable;

    public $message;

    public function __construct(ContactMessage $message)
    {
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'Contact',
            'title' => 'Nouveau message de ' . $this->message->name,
            'url' => route('admin.messages.show', $this->message->id),
            'icon' => 'fa-envelope'
        ];
    }
}
