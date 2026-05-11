@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            {{-- 絞り込みフォーム --}}
            <div class="card card-outline card-secondary mb-3">
                <div class="card-header">
                    <h3 class="card-title">絞り込み</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <form method="get" action="{{ url('admin/contact') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>ステータス</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">すべて</option>
                                    @foreach($statusLabels as $val => $label)
                                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>問い合わせ種別</label>
                                <select name="related_type" class="form-control form-control-sm">
                                    <option value="">すべて</option>
                                    @foreach($relatedTypeLabels as $val => $label)
                                        <option value="{{ $val }}" {{ request('related_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-search"></i> 検索</button>
                                <a href="{{ url('admin/contact') }}" class="btn btn-secondary btn-sm">クリア</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">お問い合わせ一覧</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if($records->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap table-list">
                                <thead>
                                    <tr>
                                        <th>種別</th>
                                        <th>氏名</th>
                                        <th>メール</th>
                                        <th>件名</th>
                                        <th>ステータス</th>
                                        <th>受信日時</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                        @php
                                            $badgeClass = match($record->status) {
                                                0 => 'badge-danger',
                                                1 => 'badge-warning',
                                                2 => 'badge-success',
                                                default => 'badge-light',
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $relatedTypeLabels[$record->related_type] ?? 'その他' }}</td>
                                            <td>{{ $record->name }}</td>
                                            <td>{{ $record->email }}</td>
                                            <td>{{ Str::limit($record->subject, 30) }}</td>
                                            <td><span class="badge {{ $badgeClass }}">{{ $statusLabels[$record->status] ?? '-' }}</span></td>
                                            <td>{{ $record->created_at->format('Y/m/d H:i') }}</td>
                                            <td class="text-right">
                                                <a href="{{ url('admin/contact/' . $record->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"> 詳細</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">お問い合わせはありません。</p>
                    @endif
                </div>
                {{ $records->appends(request()->input())->links('vendor.pagination.admin-default') }}
            </div>
        </section>
    </div>
@endsection
