@extends('admin.layouts.application')

@section('content')
    <div class="content-wrapper">
        @include('admin.components.content-header')

        <section class="content">
            @include('admin.components.save-status')

            {{-- 月ナビゲーション --}}
            @php
                $prevMonth = \Illuminate\Support\Carbon::createFromFormat('Y-m', $month)->subMonth()->format('Y-m');
                $nextMonth = \Illuminate\Support\Carbon::createFromFormat('Y-m', $month)->addMonth()->format('Y-m');
                $monthLabel = \Illuminate\Support\Carbon::createFromFormat('Y-m', $month)->format('Y年n月');
                $dayOfWeekJa = ['日','月','火','水','木','金','土'];
            @endphp

            <div class="d-flex align-items-center mb-3">
                <a href="{{ url('admin/shop-schedule?month=' . $prevMonth) }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fas fa-chevron-left"></i> 前月
                </a>
                <h4 class="mb-0 mx-3">{{ $monthLabel }}</h4>
                <a href="{{ url('admin/shop-schedule?month=' . $nextMonth) }}" class="btn btn-secondary btn-sm ml-2">
                    次月 <i class="fas fa-chevron-right"></i>
                </a>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">喫茶店 営業スケジュール</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ url('admin/shop-schedule') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="month" value="{{ $month }}">

                    {{-- 一括変更ツールバー --}}
                    <div class="card-body border-bottom py-2 px-3">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="custom-control custom-checkbox mr-3">
                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                <label class="custom-control-label font-weight-bold" for="checkAll">全選択</label>
                            </div>
                            <button type="button" id="btnBulkUpdate" class="btn btn-warning btn-sm" disabled>
                                <i class="fas fa-edit"></i> チェックした日を一括変更
                            </button>
                            <span id="checkedCount" class="text-muted small ml-2">0件選択中</span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="40" class="text-center">選択</th>
                                        <th width="80">日付</th>
                                        <th width="40">曜日</th>
                                        <th width="180">ステータス</th>
                                        <th>メモ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($days as $i => $day)
                                        @php
                                            $dow = $day->date->dayOfWeek; // 0=Sun,6=Sat
                                            $rowClass = $dow === 0 ? 'table-danger' : ($dow === 6 ? 'table-primary' : '');
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td class="text-center align-middle">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input row-check"
                                                           id="chk_{{ $i }}"
                                                           value="{{ $day->date->format('Y-m-d') }}">
                                                    <label class="custom-control-label" for="chk_{{ $i }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $day->date->format('m/d') }}</td>
                                            <td>{{ $dayOfWeekJa[$dow] }}</td>
                                            <td>
                                                <input type="hidden" name="schedules[{{ $i }}][date]" value="{{ $day->date->format('Y-m-d') }}">
                                                <select name="schedules[{{ $i }}][status]" class="form-control form-control-sm schedule-status">
                                                    <option value="0" {{ $day->status == 0 ? 'selected' : '' }}>-（未登録）</option>
                                                    <option value="1" {{ $day->status == 1 ? 'selected' : '' }}>休（店休日）</option>
                                                    <option value="2" {{ $day->status == 2 ? 'selected' : '' }}>◯（オープン）</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="schedules[{{ $i }}][memo]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $day->memo }}" placeholder="備考">
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

    {{-- 一括変更モーダル --}}
    <div class="modal fade" id="bulkUpdateModal" tabindex="-1" role="dialog" aria-labelledby="bulkUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="bulkUpdateModalLabel">
                        <i class="fas fa-edit mr-1"></i> 一括ステータス変更
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        <span id="modalSelectedCount"></span>件の日付に対して変更を適用します。
                    </p>

                    <div class="form-group">
                        <label for="bulkStatus">ステータス <span class="text-danger">*</span></label>
                        <select id="bulkStatus" class="form-control">
                            <option value="0">-（未登録）</option>
                            <option value="1">休（店休日）</option>
                            <option value="2">◯（オープン）</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bulkMemo">メモ（任意）</label>
                        <input type="text" id="bulkMemo" class="form-control" placeholder="備考を入力（空欄で上書き）" maxlength="255">
                        <small class="text-muted">空欄のまま確定するとメモは削除されます</small>
                    </div>

                    <div id="bulkUpdateAlert" class="alert d-none" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" id="btnBulkConfirm" class="btn btn-warning">
                        <i class="fas fa-check mr-1"></i> 確定
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
(function () {
    const checkAll    = document.getElementById('checkAll');
    const rowChecks   = document.querySelectorAll('.row-check');
    const btnBulk     = document.getElementById('btnBulkUpdate');
    const countLabel  = document.getElementById('checkedCount');
    const modalCount  = document.getElementById('modalSelectedCount');
    const btnConfirm  = document.getElementById('btnBulkConfirm');
    const alertBox    = document.getElementById('bulkUpdateAlert');
    const bulkUrl     = '{{ url("admin/shop-schedule/bulk-update") }}';
    const csrfToken   = '{{ csrf_token() }}';

    // チェック数を更新する
    function updateCount() {
        const checked = document.querySelectorAll('.row-check:checked').length;
        countLabel.textContent = checked + '件選択中';
        btnBulk.disabled = checked === 0;
        checkAll.indeterminate = checked > 0 && checked < rowChecks.length;
        checkAll.checked = checked === rowChecks.length && rowChecks.length > 0;
    }

    // 全選択チェックボックス
    checkAll.addEventListener('change', function () {
        rowChecks.forEach(function (cb) { cb.checked = checkAll.checked; });
        updateCount();
    });

    // 行チェックボックス
    rowChecks.forEach(function (cb) {
        cb.addEventListener('change', updateCount);
    });

    // 一括変更ボタン → モーダル表示
    btnBulk.addEventListener('click', function () {
        const checked = document.querySelectorAll('.row-check:checked').length;
        modalCount.textContent = checked;
        document.getElementById('bulkStatus').value = '0';
        document.getElementById('bulkMemo').value   = '';
        alertBox.className = 'alert d-none';
        alertBox.textContent = '';
        $('#bulkUpdateModal').modal('show');
    });

    // 確定ボタン → AJAX 送信
    btnConfirm.addEventListener('click', function () {
        const dates = Array.from(document.querySelectorAll('.row-check:checked'))
                           .map(function (cb) { return cb.value; });
        const status = parseInt(document.getElementById('bulkStatus').value, 10);
        const memo   = document.getElementById('bulkMemo').value;

        btnConfirm.disabled = true;

        fetch(bulkUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ dates: dates, status: status, memo: memo }),
        })
        .then(function (res) {
            return res.json().then(function (data) {
                return { ok: res.ok, data: data };
            });
        })
        .then(function (result) {
            if (!result.ok) {
                showAlert('danger', result.data.message || 'エラーが発生しました');
                return;
            }
            // 成功 → フォームの select / memo も更新して整合性を保つ
            dates.forEach(function (date) {
                const hiddenInput = document.querySelector('input[type=hidden][value="' + date + '"]');
                if (!hiddenInput) return;
                const row = hiddenInput.closest('tr');
                row.querySelector('select.schedule-status').value = status;
                const memoInput = row.querySelector('input.form-control');
                memoInput.value = memo;
            });

            $('#bulkUpdateModal').modal('hide');

            // 成功トースト的なフィードバック
            showAlert('success', result.data.count + '件のスケジュールを変更しました');
            setTimeout(function () {
                alertBox.className = 'alert d-none';
            }, 3000);
        })
        .catch(function () {
            showAlert('danger', '通信エラーが発生しました');
        })
        .finally(function () {
            btnConfirm.disabled = false;
        });
    });

    function showAlert(type, message) {
        alertBox.className = 'alert alert-' + type;
        alertBox.textContent = message;
    }
}());
</script>
@endpush
