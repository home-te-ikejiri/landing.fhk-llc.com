@extends('user.layouts.application')

@section('content')

<section class="py-5 reserve-section" id="event-confirm">
    <div class="container py-3">

        <div class="row pb-3">
            <div class="col text-center">
                <h1 class="section-heading text-sub-color">申込内容の確認</h1>
                <p class="text-sub-color">以下の内容でよろしければ「申し込む」ボタンを押してください。</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="reserve-confirm-card">
                    <table class="table reserve-confirm-table">
                        <tbody>
                            @if ($event)
                            <tr>
                                <th>イベント</th>
                                <td>{{ $event->title }}</td>
                            </tr>
                            <tr>
                                <th>開催日</th>
                                <td>{{ $event->event_date->isoFormat('YYYY年M月D日（ddd）') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>参加人数</th>
                                <td>{{ $formData['num_participants'] }} 名</td>
                            </tr>
                            <tr>
                                <th>参加者名</th>
                                <td>
                                    <ol class="mb-0 ps-3">
                                        @foreach ($formData['participants'] as $name)
                                            <li>{{ $name }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <th>代表者氏名</th>
                                <td>{{ $formData['representative_name'] }}</td>
                            </tr>
                            <tr>
                                <th>代表者電話番号</th>
                                <td>{{ $formData['representative_phone'] }}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>{{ $formData['email'] }}</td>
                            </tr>
                            @if (!empty($formData['message']))
                            <tr>
                                <th>通信欄</th>
                                <td class="reserve-message-cell">{!! nl2br(e($formData['message'])) !!}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <p class="small text-muted mt-2">
                        ※ 本申込は仮予約として受け付けます。確定の可否は担当者よりメールにてご連絡いたします。
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                    <a href="{{ url('/event/' . $formData['event_id'] . '/reserve') }}" class="btn btn-outline-accent btn-reserve-back px-4">
                        <i class="bi bi-arrow-left-circle me-1"></i>入力に戻る
                    </a>
                    <form action="{{ route('user.event.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-accent btn-reserve-submit px-5">
                            <i class="bi bi-check-circle me-2"></i>申し込む
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
