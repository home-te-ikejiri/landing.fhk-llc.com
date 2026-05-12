@extends('user.layouts.application')

@section('title', 'お問い合わせ完了 | 珈琲えんがわ')

@section('content')

<section class="py-5 contact-section" id="contact-complete">
    <div class="container py-3">

        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="contact-complete-card">
                    <div class="complete-icon mb-4">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="text-sub-color mb-3">送信が完了しました</h2>
                    <p class="text-sub-color mb-2">お問い合わせいただきありがとうございます。</p>
                    <p class="text-sub-color mb-4">
                        内容を確認の上、担当者よりご連絡いたします。<br>
                        通常2〜3営業日以内にご返信いたします。
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-accent px-5">
                        <i class="bi bi-house-fill me-2"></i>トップページへ戻る
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
