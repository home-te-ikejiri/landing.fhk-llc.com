@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">イベント一覧</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col text-right">
                        <a href="{{ url('admin/event/create') }}" class="btn btn-info mb-2">
                            <i class="fas fa-plus"></i> 新規追加
                        </a>
                    </div>
                    @if($records->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap table-list table-center">
                                <thead>
                                    <tr>
                                        <th>開催日</th>
                                        <th>タイトル</th>
                                        <th>時間</th>
                                        <th>定員</th>
                                        <th>参加費</th>
                                        <th>ステータス</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                        <tr>
                                            <td>{{ $record->event_date->format('Y.m.d') }}</td>
                                            <td>{{ $record->title }}</td>
                                            <td>{{ substr($record->start_time, 0, 5) }}〜{{ substr($record->end_time, 0, 5) }}</td>
                                            <td>{{ $record->capacity }}名</td>
                                            <td>{{ $record->price > 0 ? '¥' . number_format($record->price) : '無料' }}</td>
                                            <td>
                                                @if($record->status === \App\Models\Event::STATUS_PUBLISHED)
                                                    <span class="badge badge-success">公開</span>
                                                @elseif($record->status === \App\Models\Event::STATUS_ENDED)
                                                    <span class="badge badge-secondary">終了</span>
                                                @else
                                                    <span class="badge badge-warning">非公開</span>
                                                @endif
                                            </td>
                                            <td class="project-actions text-right">
                                                <a href="{{ url('admin/event/' . $record->id . '/edit') }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-pencil-alt"> 編集</i>
                                                </a>
                                                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $record->id }}">
                                                    <i class="fas fa-trash"> 削除</i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>イベントはありません。</p>
                    @endif
                </div>

                {{ $records->appends(request()->input())->links('vendor.pagination.admin-default') }}
            </div>

            <div class="popup delete-popup" style="display: none;">
                <div class="content">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    <p>イベントを削除しますか？</p>
                    <div class="btn__grid">
                        <button class="cancel">キャンセル</button>
                        <button class="keep btn-confirm-delete">削除</button>
                    </div>
                </div>
            </div>

            <div class="popup unselected-popup" style="display: none;">
                <div class="content">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    <p>削除する項目を選択してください</p>
                    <div class="btn__grid">
                        <button class="cancel">OK</button>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <input type="hidden" name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" id="target" value="event">
@endsection

@push('script')
    <script src="{{ asset('js/admin/bulk_delete.js') }}"></script>
@endpush
