{{ $reservation->representative_name }} 様

以下のイベントへのお申し込みについてキャンセルが完了しましたことをお知らせします。

▼ 申込番号：{{ $reservation->id }}

■ キャンセルされたお申し込み
------------------------------------------
イベント名：{{ $reservation->event->title }}
開催日　　：{{ \Carbon\Carbon::parse($reservation->event->event_date)->format('Y年m月d日') }}
@if($reservation->event->start_time)
開始時刻　：{{ substr($reservation->event->start_time, 0, 5) }}
@endif
@if($reservation->event->end_time)
終了時刻　：{{ substr($reservation->event->end_time, 0, 5) }}
@endif
参加人数　：{{ $reservation->num_participants }} 名
------------------------------------------

またのご参加をお待ちしております。
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
