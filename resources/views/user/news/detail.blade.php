@extends('user.layouts.application')

@section('content')

    <section class="bg-base-color" id="news-detail">
        <div class="container py-3">
            <h1 class="title">お知らせ</h1>
        </div>
    </section>

    <section class="py-5 text-sub-color" id="news-body">
        <div class="container py-3">
            <div class="title">
                <h2>{{ $news->title }}</h2>
                <p class="text-start"><i class="fas fa-calendar-alt"></i> {{ dateTimeFormat($news->publish_date, 'Y.m.d') }}</p>
            </div>
            <div class="row g-4">

                {!! purify($news->details) !!}

            </div>
        </div>
    </section>
    <div class="news-footer">
        <div class="text-center">
            <a href="{{ url('/') }}" class="btn btn-top">トップに戻る</a>
        </div>
    </div>

@endsection
