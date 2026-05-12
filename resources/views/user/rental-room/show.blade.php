@extends('user.layouts.application')

@section('title', 'レンタルルーム予約 | 珈琲えんがわ')

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
@endphp

<section class="py-5 reserve-section" id="rental-room-show">
    <div class="container py-3">

        <div class="row pb-3">
            <div class="col text-center">
                <h1 class="section-heading text-sub-color">レンタルルーム予約</h1>
                <p class="text-sub-color">
                    {{ $data['date']->isoFormat('YYYY年M月D日（ddd）') }}
                </p>
            </div>
        </div>

        {{-- エラーメッセージ --}}
        @if ($errors->any())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center g-4">

            {{-- 時間帯テーブル --}}
            <div class="col-12 col-md-5">
                <div class="reserve-card h-100">
                    <h2 class="reserve-card-heading">空き時間帯</h2>
                    <p class="text-muted small mb-3">連続する時間帯をまとめてご選択いただけます。</p>
                    <div class="slot-table-wrap">
                        <table class="table slot-table mb-0">
                            <thead>
                                <tr>
                                    <th>時間帯</th>
                                    <th class="text-center">状況</th>
                                    <th class="text-center">残席</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['hours'] as $slot)
                                <tr class="slot-row {{ $slot['status'] === 'blocked' ? 'slot-blocked' : 'slot-open' }}">
                                    <td class="slot-label">{{ $slot['label'] }}</td>
                                    <td class="text-center">
                                        @if ($slot['status'] === 'available')
                                            <span class="slot-badge-open">◯</span>
                                        @else
                                            <span class="slot-badge-blocked">✕</span>
                                        @endif
                                    </td>
                                    <td class="text-center slot-remaining">
                                        @if ($slot['status'] === 'available')
                                            {{ $slot['remaining'] }} / {{ $data['capacity'] }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 申込フォーム --}}
            <div class="col-12 col-md-7">
                <div class="reserve-card">
                    <h2 class="reserve-card-heading">予約フォーム</h2>

                    <form action="{{ route('user.rental-room.reserve') }}" method="POST" novalidate id="rental-room-form">
                        @csrf
                        <input type="hidden" name="reservation_date" value="{{ $data['date']->format('Y-m-d') }}">

                        {{-- 開始時間 / 終了時間 --}}
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="start_time" class="form-label reserve-label">
                                    開始時間 <span class="badge-required">必須</span>
                                </label>
                                <select id="start_time" name="start_time" class="form-select reserve-input @error('start_time') is-invalid @enderror">
                                    <option value="">選択してください</option>
                                    @foreach ($data['hours'] as $slot)
                                        @if ($slot['status'] === 'available')
                                        <option value="{{ $slot['hour'] }}" {{ old('start_time') == $slot['hour'] ? 'selected' : '' }}>
                                            {{ sprintf('%02d:00', $slot['hour']) }}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="end_time" class="form-label reserve-label">
                                    終了時間 <span class="badge-required">必須</span>
                                </label>
                                <select id="end_time" name="end_time" class="form-select reserve-input @error('end_time') is-invalid @enderror">
                                    <option value="">選択してください</option>
                                    @foreach ($data['hours'] as $slot)
                                        @if ($slot['status'] === 'available')
                                        <option value="{{ $slot['hour'] + 1 }}" {{ old('end_time') == $slot['hour'] + 1 ? 'selected' : '' }}>
                                            {{ sprintf('%02d:00', $slot['hour'] + 1) }}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- 利用種別 --}}
                        <div class="mb-3">
                            <label class="form-label reserve-label">
                                利用種別 <span class="badge-required">必須</span>
                            </label>
                            <div class="d-flex gap-4 flex-wrap">
                                @foreach ($usageLabels as $val => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="usage_type" id="usage_type_{{ $val }}" value="{{ $val }}"
                                        {{ old('usage_type', '') == $val ? 'checked' : '' }}>
                                    <label class="form-check-label" for="usage_type_{{ $val }}">{{ $label }}</label>
                                </div>
                                @endforeach
                            </div>
                            <small id="exclusive-disabled-note" class="text-danger small mt-1" style="display:none">
                                ※ 選択した時間帯にすでに予約が入っているため、占有（フロア貸し切り）は選択できません。
                            </small>
                            @error('usage_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 利用目的 --}}
                        <div class="mb-3">
                            <label for="purpose" class="form-label reserve-label">
                                利用目的 <span class="badge-required">必須</span>
                            </label>
                            <select id="purpose" name="purpose" class="form-select reserve-input @error('purpose') is-invalid @enderror">
                                <option value="">選択してください</option>
                                @foreach ($purposeLabels as $val => $label)
                                    <option value="{{ $val }}" {{ old('purpose') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 利用人数 --}}
                        <div class="mb-3">
                            <label for="num_people" class="form-label reserve-label">
                                利用人数 <span class="badge-required">必須</span>
                            </label>
                            <div class="input-group" style="max-width:150px">
                                <input type="number" id="num_people" name="num_people" min="1" max="50"
                                    class="form-control reserve-input @error('num_people') is-invalid @enderror"
                                    value="{{ old('num_people', 1) }}">
                                <span class="input-group-text">名</span>
                                @error('num_people')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- お名前 --}}
                        <div class="mb-3">
                            <label for="name" class="form-label reserve-label">
                                お名前 <span class="badge-required">必須</span>
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-control reserve-input @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="例：山田 太郎" autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- メールアドレス --}}
                        <div class="mb-3">
                            <label for="email" class="form-label reserve-label">
                                メールアドレス <span class="badge-required">必須</span>
                            </label>
                            <input type="email" id="email" name="email"
                                class="form-control reserve-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="例：example@mail.com" autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 電話番号 --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label reserve-label">
                                電話番号 <span class="badge-required">必須</span>
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="form-control reserve-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="例：026-000-0000" autocomplete="tel">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 通信欄 --}}
                        <div class="mb-4">
                            <label for="message" class="form-label reserve-label">
                                通信欄 <span class="badge-optional">任意</span>
                            </label>
                            <textarea id="message" name="message" rows="4"
                                class="form-control reserve-input @error('message') is-invalid @enderror"
                                placeholder="ご質問・ご要望などがあればご記入ください">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-accent btn-reserve-submit px-5">
                                <i class="bi bi-arrow-right-circle me-2"></i>確認画面へ
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>{{-- /row --}}

        <div class="text-center mt-4">
            <a href="{{ url('/') }}#calendar" class="btn btn-outline-accent px-4">
                <i class="bi bi-arrow-left-circle me-1"></i>カレンダーに戻る
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    // サーバーから受け取った時間帯データ（hour, status, has_reservation を含む）
    const slotsData      = @json($data['hours']);
    const startSelect    = document.getElementById('start_time');
    const endSelect      = document.getElementById('end_time');
    const exclusiveRadio = document.getElementById('usage_type_1');
    const exclusiveNote  = document.getElementById('exclusive-disabled-note');

    if (!startSelect || !endSelect || !exclusiveRadio) return;

    /**
     * 選択中の時間範囲 [start, end) に既存予約があれば占有ラジオを無効化する
     */
    function checkExclusive() {
        const start = parseInt(startSelect.value, 10);
        const end   = parseInt(endSelect.value,   10);

        if (isNaN(start) || isNaN(end) || start >= end) {
            setExclusiveEnabled(true);
            return;
        }

        // 選択範囲 [start, end) の各コマに予約があるか確認
        const hasReservation = slotsData.some(function (slot) {
            return slot.hour >= start && slot.hour < end && slot.has_reservation;
        });

        setExclusiveEnabled(!hasReservation);
    }

    function setExclusiveEnabled(enabled) {
        exclusiveRadio.disabled = !enabled;
        if (!enabled) {
            if (exclusiveRadio.checked) {
                exclusiveRadio.checked = false;
            }
            if (exclusiveNote) exclusiveNote.style.display = 'block';
        } else {
            if (exclusiveNote) exclusiveNote.style.display = 'none';
        }
    }

    startSelect.addEventListener('change', checkExclusive);
    endSelect.addEventListener('change',   checkExclusive);

    // バリデーション失敗後の値復元時にも評価
    checkExclusive();
}());
</script>
@endpush
