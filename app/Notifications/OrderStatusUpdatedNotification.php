<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdatedNotification extends Notification
{
    private array $labels = [
        'pending'    => 'Menunggu Konfirmasi',
        'processing' => 'Sedang Diproses',
        'shipped'    => 'Dalam Pengiriman',
        'delivered'  => 'Telah Diterima',
        'cancelled'  => 'Dibatalkan',
    ];

    public function __construct(private Order $order, private string $oldStatus) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $label = $this->labels[$this->order->status] ?? $this->order->status;

        return (new MailMessage)
            ->subject('Update Pesanan #' . $this->order->order_number . ' – ' . $label)
            ->view('emails.order-status', [
                'order'  => $this->order,
                'name'   => $notifiable->name,
                'label'  => $label,
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        $label = $this->labels[$this->order->status] ?? $this->order->status;
        return [
            'type'         => 'order_status_updated',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'status'       => $this->order->status,
            'message'      => 'Pesanan #' . $this->order->order_number . ' — ' . $label,
        ];
    }
}
