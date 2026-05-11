{{ $reservation->name }} 様

このたびは珈琲えんがわ レンタルルームにご予約いただきありがとうございます。
以下の内容でご予約が確定いたしました。

▼ 予約番号：{{ $reservation->id }}

■ ご予約内容
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
------------------------------------------

当日はお気をつけてお越しください。
ご不明な点はお問い合わせください。
@if($extraNote)

■ 担当者よりメッセージ
------------------------------------------
{{ $extraNote }}
------------------------------------------
@endif

お問い合わせ：{{ url('/contact') }}

------------------------------------------
珈琲えんがわ
{{ config('app.url') }}

このメールは自動送信です。このメールへの返信はできません。
