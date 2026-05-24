<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlacedNotification extends Notification
{
    public function __construct(private Order $order) {}

    public function via(object $notifiable): array
    {
        return $notifiable->isAdmin() ? ['database'] : ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pesanan #' . $this->order->order_number . ' Berhasil Dibuat')
            ->view('emails.order-placed', [
                'order' => $this->order,
                'name'  => $notifiable->name,
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'order_placed',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'total'        => $this->order->total,
            'customer'     => $this->order->user->name ?? '-',
            'message'      => 'Pesanan baru #' . $this->order->order_number . ' dari ' . ($this->order->user->name ?? '-'),
        ];
    }
}
