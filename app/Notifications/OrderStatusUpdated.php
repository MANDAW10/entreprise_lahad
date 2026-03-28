<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusUpdated extends Notification
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
        $statusLabels = [
            'pending' => 'En attente',
            'processing' => 'En cours',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée'
        ];
        $label = $statusLabels[$this->order->status] ?? $this->order->status;

        return [
            'type' => 'Commande',
            'title' => 'Commande #' . $this->order->id . ' mise à jour',
            'message' => 'Le statut de votre commande est maintenant : ' . $label,
            'url' => route('account.orders.show', $this->order->id),
            'icon' => 'fa-box-open'
        ];
    }
}
