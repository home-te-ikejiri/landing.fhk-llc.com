@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            @php
                $prevMonth  = \Illuminate\Support\Carbon::createFromFormat('Y-m', $month)->subMonth()->format('Y-m');
                $nextMonth  = \Illuminate\Support\Carbon::createFromFormat('Y-m', $month)->addMonth()->format('Y-m');
                $monthLabel = \Illuminate\Support\Carbon::createFromFormat('Y-m', $month)->format('Y年n月');
                $dayOfWeekJa = ['日','月','火','水','木','金','土'];
            @endphp

            <div class="d-flex align-items-center mb-3">
                <a href="{{ url('admin/rental-room-schedule?month=' . $prevMonth) }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fas fa-chevron-left"></i> 前月
                </a>
                <h4 class="mb-0 mx-3">{{ $monthLabel }}</h4>
                <a href="{{ url('admin/rental-room-schedule?month=' . $nextMonth) }}" class="btn btn-secondary btn-sm ml-2">
                    次月 <i class="fas fa-chevron-right"></i>
                </a>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">レンタルルーム 日別スケジュール</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ url('admin/rental-room-schedule') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="month" value="{{ $month }}">

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="80">日付</th>
                                        <th width="40">曜日</th>
                                        <th width="200">ステータス</th>
                                        <th>メモ</th>
                                        <th width="120">時間枠管理</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($days as $i => $day)
                                        @php
                                            $dow = $day->date->dayOfWeek;
                                            $rowClass = $dow === 0 ? 'table-danger' : ($dow === 6 ? 'table-primary' : '');
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td>{{ $day->date->format('m/d') }}</td>
                                            <td>{{ $dayOfWeekJa[$dow] }}</td>
                                            <td>
                                                <input type="hidden" name="schedules[{{ $i }}][date]" value="{{ $day->date->format('Y-m-d') }}">
                                                <select name="schedules[{{ $i }}][status]" class="form-control form-control-sm">
                                                    <option value="0" {{ $day->status == 0 ? 'selected' : '' }}>-（未登録）</option>
                                                    <option value="1" {{ $day->status == 1 ? 'selected' : '' }}>休（店休日）</option>
                                                    <option value="2" {{ $day->status == 2 ? 'selected' : '' }}>◯（営業）</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="schedules[{{ $i }}][memo]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $day->memo }}" placeholder="備考">
                                            </td>
                                            <td class="text-center">
                                                @if($day->status == 2)
                                                    <a href="{{ url('admin/rental-room-time-slot/' . $day->date->format('Y-m-d')) }}"
                                                       class="btn btn-outline-info btn-sm">
                                                        <i class="fas fa-clock"></i> 時間枠
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col text-center">
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
