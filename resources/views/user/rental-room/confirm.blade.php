@extends('user.layouts.application')

@section('content')
@php
    $purposeLabels = [
        0 => '打ち合わせ',
        1 => 'セミナー',
        2 => 'イベント',
        3 => '席利用',
        4 => 'その他',
    ];
    $usageLabels = [
        0 => '共有（席のみ）',
        1 => '占有（フロア貸し切り）',
    ];
    $dateFormatted = \Carbon\Carbon::parse($formData['reservation_date'])->isoFormat('YYYY年M月D日（ddd）');
@endphp

<section class="py-5 reserve-section" id="rental-room-confirm">
    <div class="container py-3">

        <div class="row pb-3">
            <div class="col text-center">
                <h1 class="section-heading text-sub-color">予約内容の確認</h1>
                <p class="text-sub-color">以下の内容でよろしければ「予約する」ボタンを押してください。</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="reserve-confirm-card">
                    <table class="table reserve-confirm-table">
                        <tbody>
                            <tr>
                                <th>予約日</th>
                                <td>{{ $dateFormatted }}</td>
                            </tr>
                            <tr>
                                <th>時間</th>
                                <td>{{ sprintf('%02d:00〜%02d:00', $formData['start_time'], $formData['end_time']) }}</td>
                            </tr>
                            <tr>
                                <th>利用種別</th>
                                <td>{{ $usageLabels[$formData['usage_type']] ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>利用目的</th>
                                <td>{{ $purposeLabels[$formData['purpose']] ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>利用人数</th>
                                <td>{{ $formData['num_people'] }} 名</td>
                            </tr>
                            <tr>
                                <th>お名前</th>
                                <td>{{ $formData['name'] }}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>{{ $formData['email'] }}</td>
                            </tr>
                            <tr>
                                <th>電話番号</th>
                                <td>{{ $formData['phone'] }}</td>
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
                        ※ 本予約は仮予約として受け付けます。確定の可否は担当者よりメールにてご連絡いたします。
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                    <a href="{{ url('/rental-room/' . $formData['reservation_date']) }}" class="btn btn-outline-accent btn-reserve-back px-4">
                        <i class="bi bi-arrow-left-circle me-1"></i>入力に戻る
                    </a>
                    <form action="{{ route('user.rental-room.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-accent btn-reserve-submit px-5">
                            <i class="bi bi-check-circle me-2"></i>予約する
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
