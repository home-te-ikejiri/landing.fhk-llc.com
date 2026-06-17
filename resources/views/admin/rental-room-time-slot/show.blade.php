@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            <div class="mb-3">
                <a href="{{ url('admin/rental-room-schedule?month=' . $backMonth) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> スケジュール一覧へ戻る
                </a>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $dateObj->format('Y年n月j日（') }}{{ ['日','月','火','水','木','金','土'][$dateObj->dayOfWeek] }}）
                        時間枠管理
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ url('admin/rental-room-time-slot') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="card-body">
                        <p class="text-muted mb-3">
                            <i class="fas fa-info-circle"></i>
                            「利用不可」にすると管理者都合でその時間帯を予約受付不可にします。
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="120">時間帯</th>
                                        <th width="160">設定</th>
                                        <th>管理者メモ（不可にした理由等）</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($slots as $i => $slot)
                                        <tr class="{{ $slot->is_blocked ? 'table-warning' : '' }}">
                                            <td class="font-weight-bold text-center align-middle">
                                                {{ sprintf('%02d', $slot->hour) }}:00〜{{ sprintf('%02d', $slot->hour + 1) }}:00
                                            </td>
                                            <td class="text-left align-middle">
                                                <input type="hidden" name="slots[{{ $i }}][hour]" value="{{ $slot->hour }}">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="slot_ok_{{ $i }}" name="slots[{{ $i }}][is_blocked]"
                                                           class="custom-control-input" value="0"
                                                           {{ !$slot->is_blocked ? 'checked' : '' }}>
                                                    <label class="custom-control-label text-success" for="slot_ok_{{ $i }}">
                                                        <i class="fas fa-circle"></i> 受付可
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="slot_ng_{{ $i }}" name="slots[{{ $i }}][is_blocked]"
                                                           class="custom-control-input" value="1"
                                                           {{ $slot->is_blocked ? 'checked' : '' }}>
                                                    <label class="custom-control-label text-danger" for="slot_ng_{{ $i }}">
                                                        <i class="fas fa-times-circle"></i> 利用不可
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="slots[{{ $i }}][admin_memo]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $slot->admin_memo }}" placeholder="理由など（任意）">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col text-center">
                            <a href="{{ url('admin/rental-room-schedule?month=' . $backMonth) }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-success btn-submit">
                                <i class="fas fa-save"></i> 保存
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
