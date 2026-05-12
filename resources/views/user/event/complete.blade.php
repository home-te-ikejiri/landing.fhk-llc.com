@extends('user.layouts.application')

@section('title', 'イベント予約完了 | 珈琲えんがわ')

@section('content')

<section class="py-5 reserve-section" id="event-complete">
    <div class="container py-3">

        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <div class="reserve-complete-card">
                    <div class="complete-icon mb-4">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="text-sub-color mb-3">仮予約を受け付けました</h2>
                    <p class="text-sub-color mb-2">ご申込ありがとうございます。</p>
                    <p class="text-sub-color mb-4">
                        申込内容を確認の上、担当者よりメールにてご連絡いたします。<br>
                        通常2〜3営業日以内にご返信いたします。
                    </p>
                    <a href="{{ url('/') }}#calendar" class="btn btn-accent px-5">
                        <i class="bi bi-calendar3 me-2"></i>カレンダーへ戻る
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
