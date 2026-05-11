{{ $reservation->representative_name }} 様

このたびは珈琲えんがわのイベントへお申し込みいただきありがとうございます。
以下の内容で仮申込を承りました。

担当者が内容を確認後、改めてご連絡いたします。
なお、仮申込の段階では正式な受付確定ではありませんのでご了承ください。

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
@if($reservation->event->fee !== null)
参加費　　：{{ number_format($reservation->event->fee) }} 円
@endif

■ お申込み内容
------------------------------------------
参加人数　：{{ $reservation->num_participants }} 名
@if($reservation->participants->isNotEmpty())

参加者氏名：
@foreach($reservation->participants as $i => $participant)
  {{ $i + 1 }}. {{ $participant->name }}
@endforeach
@endif
@if($reservation->message)

備考
{{ $reservation->message }}
@endif
------------------------------------------

ご不明な点はお気軽にお問い合わせください。
申込番号をお控えのうえ、お問い合わせいただくとスムーズです。

お問い合わせ：{{ url('/contact') }}

------------------------------------------
珈琲えんがわ
{{ config('app.url') }}

このメールは自動送信です。このメールへの返信はできません。
