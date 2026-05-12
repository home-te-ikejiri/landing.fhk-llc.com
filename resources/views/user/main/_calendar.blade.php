{{--
    カレンダー・予約セクション
    $calendar: CalendarService::getCalendar() の戻り値
      - month      : Carbon（表示中の月）
      - prev_month : 'YYYY-MM'
      - next_month : 'YYYY-MM'
      - weeks      : [[day|null, ...], ...]  7要素/週
      - days       : [day, ...]  フラット
    day:
      - date        : Carbon
      - date_str    : 'Y-m-d'
      - dow         : int (0=日…6=土)
      - shop_status : 0=未登録 1=店休日 2=オープン
      - rental_status   : 0=未登録 1=店休日 2=営業
      - rental_available: true/false/null
      - events      : Collection<Event>
--}}

{{-- 前月/次月リンク生成ヘルパー --}}
@php
    $prevLink = url('/') . '?month=' . $calendar['prev_month'] . '#calendar';
    $nextLink = url('/') . '?month=' . $calendar['next_month'] . '#calendar';
    $monthLabel = $calendar['month']->format('Y年n月');

    // 曜日ヘッダー
    $dowLabels = ['日', '月', '火', '水', '木', '金', '土'];

    // ステータス表示ヘルパークロージャ
    $shopLabel = function(int $status): array {
        return match($status) {
            1 => ['text' => '休', 'class' => 'cal-closed'],
            2 => ['text' => '◯', 'class' => 'cal-open'],
            default => ['text' => '－', 'class' => 'cal-none'],
        };
    };
    $rentalLabel = function(int $status, ?bool $available): array {
        if ($status === 1) return ['text' => '休', 'class' => 'cal-closed'];
        if ($status === 2) {
            if ($available === true)  return ['text' => '◯', 'class' => 'cal-open'];
            if ($available === false) return ['text' => '✕', 'class' => 'cal-full'];
        }
        return ['text' => '－', 'class' => 'cal-none'];
    };
@endphp

{{-- ===== 月ナビゲーション ===== --}}
<div class="calendar-nav">
    <a href="{{ $prevLink }}" class="cal-nav-btn" data-month="{{ $calendar['prev_month'] }}" aria-label="前月"><i class="bi bi-chevron-left"></i></a>
    <span class="cal-month-title">{{ $monthLabel }}</span>
    <a href="{{ $nextLink }}" class="cal-nav-btn" data-month="{{ $calendar['next_month'] }}" aria-label="次月"><i class="bi bi-chevron-right"></i></a>
</div>

{{-- ===== 凡例 ===== --}}
<div class="cal-legend">
    <span><i class="bi bi-cup-hot-fill me-1"></i>喫茶:</span>
    <span class="cal-open">◯</span><span class="cal-legend-txt">オープン</span>
    <span class="cal-closed ms-2">休</span><span class="cal-legend-txt">店休日</span>
    <span class="ms-3"><i class="bi bi-door-open-fill me-1"></i>RM:</span>
    <span class="cal-open">◯</span><span class="cal-legend-txt">空きあり</span>
    <span class="cal-full ms-2">✕</span><span class="cal-legend-txt">満席</span>
    <span class="cal-closed ms-2">休</span><span class="cal-legend-txt">休業</span>
</div>

{{-- ===== PC カレンダー（7列テーブル） ===== --}}
<div class="calendar-pc">
    <table class="cal-table">
        <thead>
            <tr>
                @foreach($dowLabels as $i => $d)
                    <th class="{{ $i === 0 ? 'cal-sun' : ($i === 6 ? 'cal-sat' : '') }}">{{ $d }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($calendar['weeks'] as $week)
                <tr>
                    @foreach($week as $i => $day)
                        @if($day === null)
                            <td class="cal-cell cal-empty {{ $i === 0 ? 'cal-sun' : ($i === 6 ? 'cal-sat' : '') }}"></td>
                        @else
                            @php
                                $sl = $shopLabel($day['shop_status']);
                                $rl = $rentalLabel($day['rental_status'], $day['rental_available']);
                                $isToday = $day['date']->isToday();
                            @endphp
                            <td class="cal-cell {{ $day['dow'] === 0 ? 'cal-sun' : ($day['dow'] === 6 ? 'cal-sat' : '') }} {{ $isToday ? 'cal-today' : '' }} {{ !$day['date']->isPast() ? 'cal-future' : '' }}">
                                <div class="cal-day-num">
                                    @if($isToday)
                                        <span class="cal-today-badge">{{ $day['date']->day }}</span>
                                    @else
                                        {{ $day['date']->day }}
                                    @endif
                                </div>

                                {{-- 喫茶・RM ステータス --}}
                                <div class="cal-status-row">
                                    <span class="cal-label-type"><i class="bi bi-cup-hot-fill"></i></span>
                                    <span class="{{ $sl['class'] }}">{{ $sl['text'] }}</span>
                                    <span class="cal-label-type ms-2"><i class="bi bi-door-open-fill"></i></span>
                                    @if($day['rental_status'] === 2 && $day['rental_available'] === true)
                                        <a href="{{ url('/rental-room/' . $day['date_str']) }}" class="{{ $rl['class'] }}">{{ $rl['text'] }}</a>
                                    @else
                                        <span class="{{ $rl['class'] }}">{{ $rl['text'] }}</span>
                                    @endif
                                </div>

                                {{-- イベント --}}
                                @foreach($day['events'] as $event)
                                    <div class="cal-event-item">
                                        @if($event->external_url)
                                            <a href="{{ $event->external_url }}" target="_blank" rel="noopener noreferrer" class="cal-event-link">
                                                <i class="bi bi-calendar-event-fill me-1"></i>{{ $event->title }}
                                            </a>
                                        @else
                                            <a href="{{ url('/event/' . $event->id) }}" class="cal-event-link">
                                                <i class="bi bi-calendar-event-fill me-1"></i>{{ $event->title }}
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ===== SP カレンダー（2列リスト） ===== --}}
<div class="calendar-sp">
    <table class="cal-sp-table">
        <thead>
            <tr>
                <th class="cal-sp-th-date">日付</th>
                <th class="cal-sp-th-content">喫茶 / RM / イベント</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calendar['days'] as $day)
                @php
                    $sl = $shopLabel($day['shop_status']);
                    $rl = $rentalLabel($day['rental_status'], $day['rental_available']);
                    $isToday = $day['date']->isToday();
                    $dowClass = $day['dow'] === 0 ? 'cal-sun' : ($day['dow'] === 6 ? 'cal-sat' : '');
                @endphp
                <tr class="{{ $dowClass }} {{ $isToday ? 'cal-today' : '' }} {{ !$day['date']->isPast() ? 'cal-future' : '' }}">
                    <td class="cal-sp-date {{ $isToday ? 'fw-bold' : '' }}">
                        {{ $day['date']->format('n/j') }}({{ $dowLabels[$day['dow']] }})
                    </td>
                    <td class="cal-sp-content">
                        {{-- 喫茶 --}}
                        <span class="cal-sp-badge"><i class="bi bi-cup-hot-fill"></i> <span class="{{ $sl['class'] }}">{{ $sl['text'] }}</span></span>

                        {{-- RM --}}
                        <span class="cal-sp-badge">
                            <i class="bi bi-door-open-fill"></i>
                            @if($day['rental_status'] === 2 && $day['rental_available'] === true)
                                <a href="{{ url('/rental-room/' . $day['date_str']) }}" class="{{ $rl['class'] }}">{{ $rl['text'] }}</a>
                            @else
                                <span class="{{ $rl['class'] }}">{{ $rl['text'] }}</span>
                            @endif
                        </span>

                        {{-- イベント --}}
                        @foreach($day['events'] as $event)
                            <div class="cal-sp-event">
                                @if($event->external_url)
                                    <a href="{{ $event->external_url }}" target="_blank" rel="noopener noreferrer" class="cal-event-link">
                                        <i class="bi bi-calendar-event-fill"></i> {{ $event->title }}
                                    </a>
                                @else
                                    <a href="{{ url('/event/' . $event->id) }}" class="cal-event-link">
                                        <i class="bi bi-calendar-event-fill"></i> {{ $event->title }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
