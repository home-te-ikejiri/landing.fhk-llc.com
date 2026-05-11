@php
    $statusLabels = [
        'confirmed'  => '確定',
        'rejected'   => '受付不可',
        'cancelled'  => 'キャンセル',
    ];
@endphp
【FHK 管理者通知】予約番号 {{ $reservation->id }} のステータスを「{{ $statusLabels[$statusKey] ?? $statusKey }}」に更新しました。

以下の内容をお客様（{{ $reservation->email }}）に送付しました。
========================================

@includeFirst([
    'emails.rental_room_status_' . $statusKey,
    'emails.rental_room_status_confirmed',
])
