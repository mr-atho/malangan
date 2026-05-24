<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'status', 'subtotal', 'shipping_cost', 'total',
        'payment_method', 'payment_status', 'shipping_name', 'shipping_phone',
        'shipping_address', 'shipping_city', 'shipping_province', 'shipping_postal_code',
        'notes', 'shipping_type', 'courier', 'tracking_number',
        'paid_at', 'shipped_at', 'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Terkirim',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'indigo',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getShippingTypeLabelAttribute()
    {
        return match ($this->shipping_type) {
            'pickup' => 'Ambil di Toko',
            'local'  => 'Pengiriman Dalam Kota Malang',
            'outside' => 'Pengiriman Luar Kota',
            default  => $this->shipping_type,
        };
    }

    public function getTrackingUrlAttribute(): ?string
    {
        if (!$this->tracking_number || !$this->courier) return null;

        return match ($this->courier) {
            'JNE'          => 'https://www.jne.co.id/id/tracking/trace?awb=' . $this->tracking_number,
            'SiCepat'      => 'https://www.sicepat.com/checkAwb?airWayBill=' . $this->tracking_number,
            'J&T'          => 'https://jet.co.id/track',
            'AnterAja'     => 'https://anteraja.id/tracking/' . $this->tracking_number,
            'Tiki'         => 'https://tiki.id/id/tracking?awb=' . $this->tracking_number,
            'Pos Indonesia' => 'https://www.posindonesia.co.id/id/tracking',
            default        => null,
        };
    }
}
