<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminAlert extends Notification
{
    use Queueable;
    public $title;
    public $message;

    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'Alerte',
            'title' => $this->title,
            'message' => $this->message,
            'url' => route('account.index'),
            'icon' => 'fa-bullhorn'
        ];
    }
}
