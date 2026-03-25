@extends('admin.layouts.application')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.components.content-header')

        <!-- Main content -->
        <section class="content">
            @include('admin.components.save-status')

            <!-- Default box -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">FAQ一覧</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <section>

                    </section>
                </div>
                <div class="card-body">
                    <div class="col text-right">
                        <a href="{{ url('admin/faq/create') }}" type="submit" class="btn btn-info mb-2"><i class="fas fa-plus"></i>
                            新規追加</a>
                    </div>
                    @if($records->isNotEmpty())
                        <div class="table-responsive">

                            <table class="table table-hover text-nowrap table-list table-center">
                                <thead>
                                    <tr>
                                        <th>タイトル</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                        <tr>
                                            <td>{{ $record->title }}</td>
                                            <td class="project-actions text-right">
                                                <a href="{{ url('admin/faq/'. $record->id .'/edit') }}" class=" btn btn-info btn-sm">
                                                    <i class="fas fa-pencil-alt"> 編集</i>
                                                </a>
                                                <button class=" btn btn-danger btn-sm btn-delete" data-id={{ $record->id }}>
                                                    <i class="fas fa-trash"> 削除</i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    @else
                        <p>お知らせはありません。</p>
                    @endif
                </div>

                {{$records->appends(request()->input())->links('vendor.pagination.admin-default')}}

            </div>
            <!-- /.card -->

            <div class="popup delete-popup" style="display: none;">
                <div class="content">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    <p id="popup-mesage">お知らせを削除しますか？</p>
                    <div class="btn__grid">
                        <input type="hidden" id="target_id" value="">
                        <input type="hidden" id="status" value="{{ config('define.common.status.none.id') }}">
                        <button class="cancel">キャンセル</button>
                        <button class="keep btn-confirm-delete" >削除</button>
                    </div>
                </div>
            </div>

            <div class="popup unselected-popup" style="display: none;">
                <div class="content">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    <p id="popup-mesage">削除する項目を選択してください</p>
                    <div class="btn__grid">
                        <button class="cancel">OK</button>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <input type="hidden" name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('script')
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('js/admin/my.bs-custom-file.js') }}"></script>
    <script src="{{ asset('js/admin/bulk_delete.js') }}"></script>
@endpush
