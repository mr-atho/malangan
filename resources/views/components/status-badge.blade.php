@props(['status'])
@php
$map = [
    'pending'    => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-100 text-yellow-700'],
    'paid'       => ['label' => 'Dibayar',             'class' => 'bg-blue-100 text-blue-700'],
    'processing' => ['label' => 'Diproses',            'class' => 'bg-purple-100 text-purple-700'],
    'shipped'    => ['label' => 'Dikirim',             'class' => 'bg-indigo-100 text-indigo-700'],
    'delivered'  => ['label' => 'Selesai',             'class' => 'bg-emerald-100 text-emerald-700'],
    'cancelled'  => ['label' => 'Dibatalkan',          'class' => 'bg-red-100 text-red-700'],
    'active'     => ['label' => 'Aktif',               'class' => 'bg-emerald-100 text-emerald-700'],
    'inactive'   => ['label' => 'Nonaktif',            'class' => 'bg-gray-100 text-gray-500'],
];
$cfg   = $map[$status] ?? ['label' => $status, 'class' => 'bg-gray-100 text-gray-500'];
$label = $slot->isNotEmpty() ? $slot : $cfg['label'];
@endphp
<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ' . $cfg['class']]) }}>
    {{ $label }}
</span>
