@extends('admin.layouts.application')

@push('article')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css">
    <style>
        /* table-responsive の overflow がドロップダウンを隠さないよう修正 */
        .table-responsive { overflow: visible; }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            <p class="req__explanation mt-0"><span>※</span>は入力必須項目です</p>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">新規追加</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ url('admin/event') }}" method="post" autocomplete="off">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-register">
                                <tbody>
                                    <tr>
                                        <th scope="row" width="180">タイトル<span class="req"></span></th>
                                        <td>
                                            @error('title') <span class="error-message">{{ $message }}</span> @enderror
                                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">開催日<span class="req"></span></th>
                                        <td>
                                            @error('event_date') <span class="error-message">{{ $message }}</span> @enderror
                                            <div class="w-25">
                                                <input type="date" class="form-control" name="event_date" value="{{ old('event_date') }}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">開始時間<span class="req"></span></th>
                                        <td>
                                            @error('start_time') <span class="error-message">{{ $message }}</span> @enderror
                                            <div class="w-25">
                                                <input type="time" class="form-control" name="start_time" value="{{ old('start_time') }}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">終了時間<span class="req"></span></th>
                                        <td>
                                            @error('end_time') <span class="error-message">{{ $message }}</span> @enderror
                                            <div class="w-25">
                                                <input type="time" class="form-control" name="end_time" value="{{ old('end_time') }}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">定員<span class="req"></span></th>
                                        <td>
                                            @error('capacity') <span class="error-message">{{ $message }}</span> @enderror
                                            <div class="w-25">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="capacity" value="{{ old('capacity', 10) }}" min="1">
                                                    <div class="input-group-append"><span class="input-group-text">名</span></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">参加費<span class="req"></span></th>
                                        <td>
                                            @error('price') <span class="error-message">{{ $message }}</span> @enderror
                                            <div class="w-25">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">¥</span></div>
                                                    <input type="number" class="form-control" name="price" value="{{ old('price', 0) }}" min="0">
                                                </div>
                                                <small class="text-muted">無料の場合は 0 を入力</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">概要</th>
                                        <td>
                                            @error('description') <span class="error-message">{{ $message }}</span> @enderror
                                            <textarea id="summernote-description" name="description">{{ old('description') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">外部申込URL</th>
                                        <td>
                                            @error('external_url') <span class="error-message">{{ $message }}</span> @enderror
                                            <input type="url" class="form-control" name="external_url" value="{{ old('external_url') }}" placeholder="https://...">
                                            <small class="text-muted">設定時はイベント詳細の申し込みボタンが外部URLへ遷移します</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ステータス<span class="req"></span></th>
                                        <td>
                                            @error('status') <span class="error-message">{{ $message }}</span> @enderror
                                            <select class="form-control w-25" name="status">
                                                <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>非公開</option>
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>公開</option>
                                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>終了</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">管理者メモ</th>
                                        <td>
                                            <textarea class="form-control" rows="3" name="admin_memo">{{ old('admin_memo') }}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col text-center">
                            <a href="{{ url('admin/event') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> 一覧へ戻る
                            </a>
                            <button type="submit" class="btn btn-success btn-submit">
                                <i class="fas fa-save"></i> 登録
                            </button>
                            <input type="hidden" name="id" value="">
                            @csrf
                            @method('POST')
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-ja-JP.min.js"></script>
    <script>
        $(function () {
            $('#summernote-description').summernote({
                lang: 'ja-JP',
                height: 300,
                toolbar: [
                    ['style',   ['style', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['font',    ['fontsize', 'color']],
                    ['para',    ['ul', 'ol', 'paragraph']],
                    ['table',   ['table']],
                    ['insert',  ['link', 'picture', 'hr']],
                    ['view',    ['fullscreen', 'codeview']],
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        uploadSummernoteImage(files[0], this);
                    }
                }
            });

            function uploadSummernoteImage(file, editor) {
                var formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    url: '{{ route("admin.event.upload-image") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $(editor).summernote('insertImage', data.url);
                    },
                    error: function () {
                        alert('画像のアップロードに失敗しました。');
                    }
                });
            }
        });
    </script>
@endpush
