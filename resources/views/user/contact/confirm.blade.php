@extends('user.layouts.application')

@section('title', 'お問い合わせ確認 | 珈琲えんがわ')

@section('content')
@php
    $relatedTypeLabels = [
        'rental_room_reservation' => 'レンタルルーム予約の変更・キャンセル',
        'event_reservation'       => 'イベント予約の変更・キャンセル',
        'other'                   => 'その他',
    ];
@endphp

<section class="py-5 contact-section" id="contact-confirm">
    <div class="container py-3">

        <div class="row pb-3">
            <div class="col text-center">
                <h1 class="section-heading text-sub-color">お問い合わせ内容の確認</h1>
                <p class="text-sub-color">以下の内容でよろしければ「送信する」ボタンを押してください。</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- 確認テーブル --}}
                <div class="contact-confirm-card">
                    <table class="table contact-confirm-table">
                        <tbody>
                            <tr>
                                <th>お名前</th>
                                <td>{{ $data['name'] }}</td>
                            </tr>
                            @if (!empty($data['kana']))
                            <tr>
                                <th>ふりがな</th>
                                <td>{{ $data['kana'] }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>メールアドレス</th>
                                <td>{{ $data['email'] }}</td>
                            </tr>
                            @if (!empty($data['phone']))
                            <tr>
                                <th>電話番号</th>
                                <td>{{ $data['phone'] }}</td>
                            </tr>
                            @endif
                            @if (!empty($data['related_type']))
                            <tr>
                                <th>お問い合わせ種別</th>
                                <td>{{ $relatedTypeLabels[$data['related_type']] ?? $data['related_type'] }}</td>
                            </tr>
                            @endif
                            @if (!empty($data['related_id_input']))
                            <tr>
                                <th>予約番号</th>
                                <td>{{ $data['related_id_input'] }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>お問い合わせ内容</th>
                                <td class="contact-message-cell">{!! nl2br(e($data['message'])) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- ボタン --}}
                <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                    {{-- 戻るボタン --}}
                    <a href="{{ route('user.contact') }}" class="btn btn-outline-accent btn-contact-back px-4">
                        <i class="bi bi-arrow-left-circle me-1"></i>入力に戻る
                    </a>

                    {{-- 送信ボタン --}}
                    <form action="{{ route('user.contact.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-accent btn-contact-submit px-5">
                            <i class="bi bi-send-fill me-2"></i>送信する
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
