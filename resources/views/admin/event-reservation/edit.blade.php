@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">予約詳細・編集</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/event-reservation/' . $record->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $record->id }}">
                        @include('admin.event-reservation._form')
                        <div class="mt-3 text-center">
                            <a href="{{ url('admin/event-reservation') }}" class="btn btn-secondary mr-2">戻る</a>
                            <button type="submit" class="btn btn-primary">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
