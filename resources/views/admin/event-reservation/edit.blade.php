@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">予約詳細・編集</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/event-reservation/' . $record->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $record->id }}">
                        @include('admin.event-reservation._form')

                        {{-- メール送信オプション（編集時のみ） --}}
                        <div class="card card-outline card-warning mt-4">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-envelope mr-1"></i>メール送信</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="send_mail" name="send_mail" value="1"
                                        {{ old('send_mail') ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-bold" for="send_mail">
                                        更新時にお客様へメールを送信する
                                    </label>
                                </div>
                                <div id="mail-options" style="{{ old('send_mail') ? '' : 'display:none' }}">
                                    <p class="text-muted small mb-2">
                                        ステータスに応じたメールを送信します。追記内容はメール本文に追加されます。
                                    </p>
                                    <div class="form-group mb-0">
                                        <label for="mail_extra_note">追記内容（任意）</label>
                                        <textarea class="form-control" id="mail_extra_note" name="mail_extra_note" rows="4"
                                            placeholder="お客様へのメッセージを入力してください（メール本文末尾に追記されます）">{{ old('mail_extra_note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ url('admin/event-reservation') }}" class="btn btn-secondary mr-2">戻る</a>
                            <button type="submit" class="btn btn-primary">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
<script>
document.getElementById('send_mail').addEventListener('change', function () {
    document.getElementById('mail-options').style.display = this.checked ? '' : 'none';
});
</script>
@endpush
