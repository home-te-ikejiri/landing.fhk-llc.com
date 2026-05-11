@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">予約登録</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/rental-room-reservation') }}" method="post">
                        @csrf
                        @include('admin.rental-room-reservation._form', ['record' => null])
                        <div class="mt-3 text-center">
                            <a href="{{ url('admin/rental-room-reservation') }}" class="btn btn-secondary mr-2">戻る</a>
                            <button type="submit" class="btn btn-primary">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
