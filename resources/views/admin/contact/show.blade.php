@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">お問い合わせ詳細</h3>
                </div>
                <div class="card-body">
                    {{-- 受信内容（読み取り専用） --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-register">
                            <tbody>
                                <tr>
                                    <th scope="row" width="180" class="bg-light">種別</th>
                                    <td>{{ $relatedTypeLabels[$record->related_type] ?? 'その他' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">氏名</th>
                                    <td>{{ $record->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">メールアドレス</th>
                                    <td>{{ $record->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">電話番号</th>
                                    <td>{{ $record->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">件名</th>
                                    <td>{{ $record->subject ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">本文</th>
                                    <td style="white-space: pre-wrap;">{{ $record->message }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">受信日時</th>
                                    <td>{{ $record->created_at->format('Y/m/d H:i') }}</td>
                                </tr>
                                @if($record->related_id)
                                    <tr>
                                        <th scope="row" class="bg-light">関連予約ID</th>
                                        <td>{{ $record->related_id }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- 対応フォーム --}}
                    <form action="{{ url('admin/contact/' . $record->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="table-responsive">
                            <table class="table text-nowrap table-register">
                                <tbody>
                                    <tr>
                                        <th scope="row" width="180">ステータス<span class="req"></span></th>
                                        <td>
                                            @error('status') <span class="error-message">{{ $message }}</span> @enderror
                                            <select name="status" class="form-control w-25">
                                                @foreach($statusLabels as $val => $label)
                                                    <option value="{{ $val }}" {{ old('status', $record->status) == $val ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">管理者メモ</th>
                                        <td>
                                            <textarea class="form-control" rows="4" name="admin_memo">{{ old('admin_memo', $record->admin_memo) }}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ url('admin/contact') }}" class="btn btn-secondary mr-2">戻る</a>
                            <button type="submit" class="btn btn-primary">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
