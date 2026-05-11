@extends('user.layouts.application')

@section('content')

<section class="py-5 contact-section" id="contact">
    <div class="container py-3">

        <div class="row pb-3">
            <div class="col text-center">
                <h1 class="section-heading text-sub-color">お問い合わせ</h1>
                <p class="text-sub-color">レンタルルームのご予約、イベントのご相談など、お気軽にお問い合わせください。</p>
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
                <div class="contact-form-card">
                    <form action="{{ route('user.contact.confirm') }}" method="POST" novalidate>
                        @csrf

                        {{-- お名前 --}}
                        <div class="mb-4">
                            <label for="name" class="form-label contact-label">
                                お名前 <span class="badge-required">必須</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control contact-input @error('name') is-invalid @enderror"
                                value="{{ old('name', $old['name'] ?? '') }}"
                                placeholder="例：山田 太郎"
                                autocomplete="name"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ふりがな --}}
                        <div class="mb-4">
                            <label for="kana" class="form-label contact-label">
                                ふりがな <span class="badge-optional">任意</span>
                            </label>
                            <input
                                type="text"
                                id="kana"
                                name="kana"
                                class="form-control contact-input @error('kana') is-invalid @enderror"
                                value="{{ old('kana', $old['kana'] ?? '') }}"
                                placeholder="例：やまだ たろう"
                                autocomplete="off"
                            >
                            @error('kana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- メールアドレス --}}
                        <div class="mb-4">
                            <label for="email" class="form-label contact-label">
                                メールアドレス <span class="badge-required">必須</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control contact-input @error('email') is-invalid @enderror"
                                value="{{ old('email', $old['email'] ?? '') }}"
                                placeholder="例：info@example.com"
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 電話番号 --}}
                        <div class="mb-4">
                            <label for="phone" class="form-label contact-label">
                                電話番号 <span class="badge-optional">任意</span>
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                class="form-control contact-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $old['phone'] ?? '') }}"
                                placeholder="例：026-000-0000"
                                autocomplete="tel"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- お問い合わせ種別 --}}
                        <div class="mb-4">
                            <label for="related_type" class="form-label contact-label">
                                お問い合わせ種別 <span class="badge-optional">任意</span>
                            </label>
                            <select id="related_type" name="related_type"
                                class="form-select contact-input @error('related_type') is-invalid @enderror">
                                <option value="">選択してください（任意）</option>
                                <option value="rental_room_reservation"
                                    {{ old('related_type', $old['related_type'] ?? '') === 'rental_room_reservation' ? 'selected' : '' }}>
                                    レンタルルーム予約の変更・キャンセル
                                </option>
                                <option value="event_reservation"
                                    {{ old('related_type', $old['related_type'] ?? '') === 'event_reservation' ? 'selected' : '' }}>
                                    イベント予約の変更・キャンセル
                                </option>
                                <option value="other"
                                    {{ old('related_type', $old['related_type'] ?? '') === 'other' ? 'selected' : '' }}>
                                    その他
                                </option>
                            </select>
                            @error('related_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 予約番号（種別が予約系のときのみ表示） --}}
                        <div class="mb-4" id="related-id-wrap"
                            style="{{ in_array(old('related_type', $old['related_type'] ?? ''), ['rental_room_reservation','event_reservation']) ? '' : 'display:none' }}">
                            <label for="related_id_input" class="form-label contact-label">
                                予約番号 <span class="badge-optional">任意</span>
                            </label>
                            <input
                                type="number"
                                id="related_id_input"
                                name="related_id_input"
                                min="1"
                                class="form-control contact-input @error('related_id_input') is-invalid @enderror"
                                value="{{ old('related_id_input', $old['related_id_input'] ?? '') }}"
                                placeholder="例：123"
                                style="max-width:200px"
                            >
                            <div class="form-text">確認メールに記載されている予約番号を入力してください。</div>
                            @error('related_id_input')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- お問い合わせ内容 --}}
                        <div class="mb-5">
                            <label for="message" class="form-label contact-label">
                                お問い合わせ内容 <span class="badge-required">必須</span>
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="7"
                                class="form-control contact-input @error('message') is-invalid @enderror"
                                placeholder="ご質問・ご要望・ご予約のご相談などをご記入ください。"
                            >{{ old('message', $old['message'] ?? '') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-accent btn-contact-submit px-5">
                                <i class="bi bi-arrow-right-circle-fill me-2"></i>確認画面へ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
(function () {
    const sel  = document.getElementById('related_type');
    const wrap = document.getElementById('related-id-wrap');
    const reservationTypes = ['rental_room_reservation', 'event_reservation'];

    function toggle() {
        wrap.style.display = reservationTypes.includes(sel.value) ? '' : 'none';
        if (!reservationTypes.includes(sel.value)) {
            document.getElementById('related_id_input').value = '';
        }
    }

    sel.addEventListener('change', toggle);
})();
</script>
@endpush

@endsection
