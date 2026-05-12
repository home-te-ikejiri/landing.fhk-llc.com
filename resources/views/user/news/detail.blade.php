@extends('user.layouts.application')

@section('title', $news->title . ' | 珈琲えんがわ')

@section('content')

    {{-- ページヘッダー --}}
    <section class="page-header bg-sub-color">
        <div class="container py-4 text-center">
            <h1 class="text-base-color mb-1">お知らせ</h1>
        </div>
    </section>

    {{-- 記事本文 --}}
    <section class="py-5 bg-cream text-sub-color" id="news-detail">
        <div class="container py-3">

            {{-- パンくず / 戻るリンク --}}
            {{-- <div class="mb-4">
                <a href="{{ url('/') }}#news" class="text-accent text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i>お知らせ一覧に戻る
                </a>
            </div> --}}

            {{-- 記事カード --}}
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="news-article-card">
                        <div class="news-article-header">
                            <span class="news-article-date">
                                <i class="bi bi-calendar3 me-1"></i>{{ dateTimeFormat($news->publish_date, 'Y.m.d') }}
                            </span>
                            <h2 class="news-article-title">{{ $news->title }}</h2>
                        </div>
                        <div class="news-article-body">
                            {!! purify($news->details) !!}
                        </div>
                    </div>

                    {{-- 戻るボタン --}}
                    <div class="text-center mt-5">
                        <a href="{{ url('/') }}#news" class="btn btn-outline-accent px-5 py-2">
                            <i class="bi bi-arrow-left me-1"></i>一覧に戻る
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
