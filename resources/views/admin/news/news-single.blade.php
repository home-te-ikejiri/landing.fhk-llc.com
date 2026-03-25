@extends('system.layouts.application')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('system.components.content-header')

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">お知らせ</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="news__wrap news__single">
                        <h5 class="ttl-05">{{ $record->title }}</h5>
                        <span class="date">{{ dateTimeFormat($record->publish_date, 'Y.m.d') }}</span>
                        <p class="mt-3 mb-0">
                            {!! (nl2br(e($record->details))) !!}
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-secondary btn-submit" name="submit" value="update"
                            onclick="location.href='{{ url('system') }}'">戻る</button>
                    </div>
                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('js/system/my.bs-custom-file.js') }}"></script>
@endpush
