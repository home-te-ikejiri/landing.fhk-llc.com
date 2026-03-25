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
                    <h3 class="card-title">新規追加</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ url('admin/faq-category') }}" method="post" autocomplete="off">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table text-nowrap table-register">
                                <tbody>
                                    <tr>
                                        <th scope="row" width="180">タイトル<span class="req"></span></th>
                                        <td>
                                            @error('name') <span class="error-message">{{ $message }}</span> @enderror
                                            <input type="text" id="inputTest" class="form-control" name="name" value="{{ old('name') }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-success btn-submit" name="submit" value="update">
                                <i class="fas fa-save"></i> 公開
                            </button>
                            <input type="hidden" name="id" value="">
                            @csrf
                            @method('POST')
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
