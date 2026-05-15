@extends('user.layouts.application')

@section('title', $event->title . ' | 珈琲えんがわ')

@section('content')

<section class="py-5 reserve-section" id="event-show">
    <div class="container py-3">

        <div class="row pb-3">
            <div class="col text-center">
                <h1 class="section-heading text-sub-color">{{ $event->title }}</h1>
            </div>
        </div>

        @if (session('error'))
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-danger">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="reserve-card">

                    {{-- 開催情報 --}}
                    <table class="table reserve-confirm-table mb-4">
                        <tbody>
                            <tr>
                                <th>開催日</th>
                                <td>{{ $event->event_date->isoFormat('YYYY年M月D日（ddd）') }}</td>
                            </tr>
                            <tr>
                                <th>時間</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}〜{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <th>参加費</th>
                                <td>
                                    @if ($event->price > 0)
                                        {{ number_format($event->price) }} 円
                                    @else
                                        無料
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>定員</th>
                                <td>{{ $event->capacity }} 名</td>
                            </tr>
                            <tr>
                                <th>残席</th>
                                <td>
                                    @if ($remaining > 0)
                                        <span class="cal-open">{{ $remaining }} 名</span>
                                    @else
                                        <span class="cal-full">満席</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- 概要 --}}
                    @if ($event->description)
                    <div class="event-description mb-4">
                        <h3 class="event-desc-heading">イベント概要</h3>
                        <div class="event-desc-body">{!! purify($event->description) !!}</div>
                    </div>
                    @endif

                    {{-- 申し込みボタン --}}
                    <div class="text-center">
                        @if ($event->external_url)
                            <a href="{{ $event->external_url }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-accent btn-reserve-submit px-5">
                                <i class="bi bi-box-arrow-up-right me-2"></i>申し込む（外部サイト）
                            </a>
                        @elseif ($remaining > 0)
                            <a href="{{ url('/event/' . $event->id . '/reserve') }}"
                                class="btn btn-accent btn-reserve-submit px-5">
                                <i class="bi bi-pencil-square me-2"></i>申し込む
                            </a>
                        @else
                            <button class="btn btn-secondary px-5" disabled>満席のため受付終了</button>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}#calendar" class="btn btn-outline-accent px-4">
                <i class="bi bi-arrow-left-circle me-1"></i>カレンダーに戻る
            </a>
        </div>

    </div>
</section>

@endsection
