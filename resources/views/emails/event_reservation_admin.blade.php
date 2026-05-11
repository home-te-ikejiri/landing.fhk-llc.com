珈琲えんがわ イベント 仮申込通知
========================================

イベントに新規お申込みが入りました。
管理画面よりご確認のうえ、お客様へご連絡ください。

▼ 申込番号：{{ $reservation->id }}

■ イベント情報
------------------------------------------
イベント名：{{ $reservation->event->title }}
開催日　　：{{ \Carbon\Carbon::parse($reservation->event->event_date)->format('Y年m月d日') }}
@if($reservation->event->start_time)
開始時刻　：{{ substr($reservation->event->start_time, 0, 5) }}
@endif
@if($reservation->event->end_time)
終了時刻　：{{ substr($reservation->event->end_time, 0, 5) }}
@endif

■ 申込内容
------------------------------------------
参加人数　：{{ $reservation->num_participants }} 名
@if($reservation->participants->isNotEmpty())

参加者氏名：
@foreach($reservation->participants as $i => $participant)
  {{ $i + 1 }}. {{ $participant->name }}
@endforeach
@endif

■ 申込者情報
------------------------------------------
お名前　　：{{ $reservation->representative_name }}
メール　　：{{ $reservation->email }}
電話番号　：{{ $reservation->representative_phone }}
@if($reservation->message)

備考
{{ $reservation->message }}
@endif

------------------------------------------
管理画面：{{ url('/admin/event-reservations') }}

このメールは自動送信です。
珈琲えんがわ
