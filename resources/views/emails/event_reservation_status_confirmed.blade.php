{{ $reservation->representative_name }} 様

このたびは珈琲えんがわのイベントへお申し込みいただきありがとうございます。
以下の内容でお申し込みが確定いたしました。

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

■ お申し込み内容
------------------------------------------
参加人数　：{{ $reservation->num_participants }} 名
@if($reservation->participants->isNotEmpty())

参加者氏名：
@foreach($reservation->participants as $i => $participant)
  {{ $i + 1 }}. {{ $participant->name }}
@endforeach
@endif
------------------------------------------

当日は会場へお気をつけてお越しください。
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
