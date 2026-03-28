<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrder extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'Commande',
            'title' => 'Nouvelle commande #' . $this->order->id . ' (' . number_format($this->order->total, 0, ',', ' ') . ' FCFA)',
            'url' => route('admin.orders.show', $this->order->id),
            'icon' => 'fa-shopping-cart'
        ];
    }
}
