@extends('user.layouts.application')

@section('content')

<section class="py-5 reserve-section" id="event-reserve">
    <div class="container py-3">

        <div class="row pb-3">
            <div class="col text-center">
                <h1 class="section-heading text-sub-color">イベント申込</h1>
                <p class="text-sub-color">{{ $event->title }}</p>
                <p class="text-muted small">
                    {{ $event->event_date->isoFormat('YYYY年M月D日（ddd）') }}
                    {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}〜{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                    ／ 残席 {{ $remaining }} 名
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

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="reserve-card">

                    <form action="{{ route('user.event.confirm') }}" method="POST" novalidate id="event-reserve-form">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        {{-- 参加人数 --}}
                        <div class="mb-3">
                            <label for="num_participants" class="form-label reserve-label">
                                参加人数 <span class="badge-required">必須</span>
                            </label>
                            <div class="input-group" style="max-width:150px">
                                <input type="number" id="num_participants" name="num_participants"
                                    min="1" max="{{ $remaining }}"
                                    class="form-control reserve-input @error('num_participants') is-invalid @enderror"
                                    value="{{ old('num_participants', 1) }}">
                                <span class="input-group-text">名</span>
                                @error('num_participants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">※ 残席 {{ $remaining }} 名まで申込可能です。</div>
                        </div>

                        {{-- 参加者名（JS で動的追加） --}}
                        <div class="mb-3">
                            <label class="form-label reserve-label">
                                参加者名 <span class="badge-required">必須</span>
                                <span class="form-text ms-2 small">（1名ずつ入力してください）</span>
                            </label>
                            <div id="participants-container">
                                <div class="participant-row mb-2 d-flex align-items-center gap-2">
                                    <span class="participant-no text-muted small" style="min-width:2rem">1.</span>
                                    <input type="text" name="participants[]"
                                        class="form-control reserve-input @error('participants.0') is-invalid @enderror"
                                        value="{{ old('participants.0') }}"
                                        placeholder="例：山田 太郎" maxlength="100">
                                    @error('participants.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" id="add-participant" class="btn btn-sm btn-outline-accent mt-2"
                                data-max="{{ $remaining }}">
                                <i class="bi bi-plus-circle me-1"></i>参加者を追加
                            </button>
                            <div id="participant-limit-msg" class="text-muted small mt-1 d-none">
                                参加者の上限（{{ $remaining }} 名）に達しました。
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- 代表者氏名 --}}
                        <div class="mb-3">
                            <label for="representative_name" class="form-label reserve-label">
                                代表者氏名 <span class="badge-required">必須</span>
                            </label>
                            <input type="text" id="representative_name" name="representative_name"
                                class="form-control reserve-input @error('representative_name') is-invalid @enderror"
                                value="{{ old('representative_name') }}" placeholder="例：山田 太郎" autocomplete="name">
                            @error('representative_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 代表者電話番号 --}}
                        <div class="mb-3">
                            <label for="representative_phone" class="form-label reserve-label">
                                代表者電話番号 <span class="badge-required">必須</span>
                            </label>
                            <input type="tel" id="representative_phone" name="representative_phone"
                                class="form-control reserve-input @error('representative_phone') is-invalid @enderror"
                                value="{{ old('representative_phone') }}" placeholder="例：026-000-0000" autocomplete="tel">
                            @error('representative_phone')
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
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/event/' . $event->id) }}" class="btn btn-outline-accent px-4">
                <i class="bi bi-arrow-left-circle me-1"></i>イベント詳細に戻る
            </a>
        </div>

    </div>
</section>

@push('scripts')
<script>
(function () {
    const container = document.getElementById('participants-container');
    const addBtn    = document.getElementById('add-participant');
    const limitMsg  = document.getElementById('participant-limit-msg');
    const maxCount  = parseInt(addBtn.dataset.max, 10);

    function updateUI() {
        const rows = container.querySelectorAll('.participant-row');
        const count = rows.length;
        addBtn.disabled = count >= maxCount;
        limitMsg.classList.toggle('d-none', count < maxCount);
    }

    addBtn.addEventListener('click', function () {
        const rows = container.querySelectorAll('.participant-row');
        if (rows.length >= maxCount) return;

        const no  = rows.length + 1;
        const div = document.createElement('div');
        div.className = 'participant-row mb-2 d-flex align-items-center gap-2';
        div.innerHTML = `
            <span class="participant-no text-muted small" style="min-width:2rem">${no}.</span>
            <input type="text" name="participants[]" class="form-control reserve-input"
                placeholder="例：山田 花子" maxlength="100">
            <button type="button" class="btn btn-sm btn-outline-danger remove-participant" aria-label="削除">
                <i class="bi bi-x"></i>
            </button>`;
        container.appendChild(div);
        updateUI();
    });

    container.addEventListener('click', function (e) {
        if (!e.target.closest('.remove-participant')) return;
        e.target.closest('.participant-row').remove();
        // 番号振り直し
        container.querySelectorAll('.participant-no').forEach(function (el, i) {
            el.textContent = (i + 1) + '.';
        });
        updateUI();
    });

    updateUI();
})();
</script>
@endpush

@endsection
