珈琲えんがわ レンタルルーム 仮予約通知
========================================

レンタルルームに新規仮予約が入りました。
管理画面よりご確認のうえ、お客様へご連絡ください。

▼ 予約番号：{{ $reservation->id }}

■ 予約内容
------------------------------------------
予約日　　：{{ $reservation->reservation_date->format('Y年m月d日') }}
開始時刻　：{{ substr($reservation->start_time, 0, 5) }}
終了時刻　：{{ substr($reservation->end_time, 0, 5) }}
@php
    $usageLabels = [
        \App\Models\RentalRoomReservation::USAGE_TYPE_SHARED    => '共有（席のみ）',
        \App\Models\RentalRoomReservation::USAGE_TYPE_EXCLUSIVE => '占有（フロア貸し切り）',
    ];
    $purposeLabels = [
        \App\Models\RentalRoomReservation::PURPOSE_MEETING  => '打ち合わせ',
        \App\Models\RentalRoomReservation::PURPOSE_SEMINAR  => 'セミナー',
        \App\Models\RentalRoomReservation::PURPOSE_EVENT    => 'イベント',
        \App\Models\RentalRoomReservation::PURPOSE_SEAT     => '席利用',
        \App\Models\RentalRoomReservation::PURPOSE_OTHER    => 'その他',
    ];
@endphp
利用種別　：{{ $usageLabels[$reservation->usage_type] ?? $reservation->usage_type }}
利用目的　：{{ $purposeLabels[$reservation->purpose] ?? $reservation->purpose }}
人数　　　：{{ $reservation->num_people }} 名

■ お客様情報
------------------------------------------
お名前　　：{{ $reservation->name }}
メール　　：{{ $reservation->email }}
電話番号　：{{ $reservation->phone }}
@if($reservation->message)

備考
{{ $reservation->message }}
@endif

------------------------------------------
管理画面：{{ url('/admin/rental-room-reservations') }}

このメールは自動送信です。
珈琲えんがわ
