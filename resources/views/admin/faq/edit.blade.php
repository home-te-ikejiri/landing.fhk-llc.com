@extends('admin.layouts.application')

@push('article')
    <!-- TinyMCE -->
    <script src="{{ asset('assets/tinymce_6.8.3/tinymce.min.js') }}"></script>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.components.content-header')


        <!-- Main content -->
        <section class="content">
            <p class="req__explanation mt-0"><span>※</span>は入力必須項目です</p>

            <!-- Default box -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">お知らせ更新</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ url('admin/faq/' . $record->id) }}" method="post" autocomplete="off">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table text-nowrap table-register">
                                <tbody>
                                    <tr>
                                        <th scope="row" width="180">タイトル<span class="req"></span></th>
                                        <td>
                                            @error('title')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                            <input type="text" id="inputTest" class="form-control" name="title"
                                                value="{{ old('title', $record->title) }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">カテゴリ<span class="req"></span></th>
                                        <td>
                                            <select name="category_id" id="category_id"
                                                class="form-control @error('category_id') is-invalid @enderror">
                                                <option value="">選択してください</option>
                                                @foreach ($categories as $val)
                                                    <option value="{{ $val->id }}"
                                                        @if (old('category_id', $record->category_id) == $val->id) selected @endif>
                                                        {{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">詳細<span class="req"></span></th>
                                        <td>
                                            @error('body')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                            <textarea id="tinymce" class="form-control" rows="12" name="body">{!! e(old('body', $record->body)) !!}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-success btn-submit" name="submit" value="update">
                                <i class="fas fa-save"></i> 更新
                            </button>
                            <input type="hidden" name="id" value="{{ $record->id }}">
                            @csrf
                            @method('PUT')
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('script')
    <script src="{{ asset('js/user/my-tinymce.js') }}"></script>
@endpush
