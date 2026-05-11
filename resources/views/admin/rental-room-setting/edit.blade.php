@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')
            <p class="req__explanation mt-0"><span>※</span>は入力必須項目です</p>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">席数設定</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ url('admin/rental-room-setting') }}" method="post" autocomplete="off">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-register">
                                <tbody>
                                    <tr>
                                        <th scope="row" width="180">総席数<span class="req"></span></th>
                                        <td>
                                            @error('capacity') <span class="error-message">{{ $message }}</span> @enderror
                                            <div class="w-25">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="capacity"
                                                           value="{{ old('capacity', $record->capacity) }}" min="1" max="999">
                                                    <div class="input-group-append"><span class="input-group-text">席</span></div>
                                                </div>
                                            </div>
                                            <small class="text-muted">レンタルルームの同時利用可能な最大人数（席数）を設定します</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-success btn-submit">
                                <i class="fas fa-save"></i> 更新
                            </button>
                            @csrf
                            @method('PUT')
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
