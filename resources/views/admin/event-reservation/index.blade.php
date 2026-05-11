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
                <form method="get" action="{{ url('admin/event-reservation') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>イベント</label>
                                <select name="event_id" class="form-control form-control-sm">
                                    <option value="">すべて</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                            {{ $event->event_date->format('Y/m/d') }} {{ $event->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>ステータス</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">すべて</option>
                                    @foreach($statusLabels as $val => $label)
                                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-search"></i> 検索</button>
                                <a href="{{ url('admin/event-reservation') }}" class="btn btn-secondary btn-sm">クリア</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">イベント予約一覧</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col text-right">
                        <a href="{{ url('admin/event-reservation/create') }}" class="btn btn-info mb-2">
                            <i class="fas fa-plus"></i> 予約登録
                        </a>
                    </div>
                    @if($records->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-nowrap table-list">
                                <thead>
                                    <tr>
                                        <th>イベント名</th>
                                        <th>開催日</th>
                                        <th>氏名</th>
                                        <th>人数</th>
                                        <th>ステータス</th>
                                        <th>申込日時</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                        @php
                                            $badgeClass = match($record->status) {
                                                0 => 'badge-warning',
                                                1 => 'badge-success',
                                                2 => 'badge-secondary',
                                                default => 'badge-light',
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $record->event->title ?? '-' }}</td>
                                            <td>{{ $record->event->event_date->format('Y/m/d') ?? '-' }}</td>
                                            <td>{{ $record->representative_name }}</td>
                                            <td>{{ $record->num_participants }}名</td>
                                            <td><span class="badge {{ $badgeClass }}">{{ $statusLabels[$record->status] ?? '-' }}</span></td>
                                            <td>{{ $record->created_at->format('Y/m/d H:i') }}</td>
                                            <td class="text-right">
                                                <a href="{{ url('admin/event-reservation/' . $record->id . '/edit') }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-pencil-alt"> 詳細・編集</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">予約はありません。</p>
                    @endif
                </div>
                {{ $records->appends(request()->input())->links('vendor.pagination.admin-default') }}
            </div>
        </section>
    </div>
@endsection
