@php
    $statusLabels = [
        'confirmed'  => '確定',
        'cancelled'  => 'キャンセル',
    ];
@endphp
【FHK 管理者通知】申込番号 {{ $reservation->id }} のステータスを「{{ $statusLabels[$statusKey] ?? $statusKey }}」に更新しました。

以下の内容をお客様（{{ $reservation->email }}）に送付しました。
========================================

@includeFirst([
    'emails.event_reservation_status_' . $statusKey,
    'emails.event_reservation_status_confirmed',
])
