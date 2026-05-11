{{ $reservation->name }} 様

このたびは珈琲えんがわ レンタルルームのご予約をありがとうございます。
以下の内容で仮予約を承りました。

担当者が内容を確認後、改めてご連絡いたします。
なお、仮予約の段階では正式な予約確定ではありませんのでご了承ください。

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
@if($reservation->message)

備考
{{ $reservation->message }}
@endif
------------------------------------------

ご不明な点はお気軽にお問い合わせください。
予約番号をお控えのうえ、お問い合わせいただくとスムーズです。

お問い合わせ：{{ url('/contact') }}

------------------------------------------
珈琲えんがわ
{{ config('app.url') }}

このメールは自動送信です。このメールへの返信はできません。
