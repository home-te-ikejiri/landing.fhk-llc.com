{{-- イベント予約フォームの共通パーツ --}}
<div class="table-responsive">
    <table class="table text-nowrap table-register">
        <tbody>
            <tr>
                <th scope="row" width="180">イベント<span class="req"></span></th>
                <td>
                    @error('event_id') <span class="error-message">{{ $message }}</span> @enderror
                    <select name="event_id" class="form-control">
                        <option value="">選択してください</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}"
                                {{ old('event_id', $record->event_id ?? '') == $event->id ? 'selected' : '' }}>
                                {{ $event->event_date->format('Y/m/d') }} {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">代表者氏名<span class="req"></span></th>
                <td>
                    @error('representative_name') <span class="error-message">{{ $message }}</span> @enderror
                    <input type="text" class="form-control" name="representative_name"
                           value="{{ old('representative_name', $record->representative_name ?? '') }}">
                </td>
            </tr>
            <tr>
                <th scope="row">メールアドレス<span class="req"></span></th>
                <td>
                    @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    <input type="email" class="form-control" name="email"
                           value="{{ old('email', $record->email ?? '') }}">
                </td>
            </tr>
            <tr>
                <th scope="row">代表者電話番号<span class="req"></span></th>
                <td>
                    @error('representative_phone') <span class="error-message">{{ $message }}</span> @enderror
                    <input type="tel" class="form-control w-50" name="representative_phone"
                           value="{{ old('representative_phone', $record->representative_phone ?? '') }}">
                </td>
            </tr>
            <tr>
                <th scope="row">参加人数<span class="req"></span></th>
                <td>
                    @error('num_participants') <span class="error-message">{{ $message }}</span> @enderror
                    <div class="w-25">
                        <div class="input-group">
                            <input type="number" class="form-control" name="num_participants" min="1"
                                   value="{{ old('num_participants', $record->num_participants ?? '') }}">
                            <div class="input-group-append"><span class="input-group-text">名</span></div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">通信欄</th>
                <td>
                    <textarea class="form-control" rows="3" name="message">{{ old('message', $record->message ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">ステータス<span class="req"></span></th>
                <td>
                    @error('status') <span class="error-message">{{ $message }}</span> @enderror
                    <select name="status" class="form-control w-25">
                        @foreach($statusLabels as $val => $label)
                            <option value="{{ $val }}" {{ old('status', $record->status ?? 0) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">管理者メモ</th>
                <td>
                    <textarea class="form-control" rows="3" name="admin_memo">{{ old('admin_memo', $record->admin_memo ?? '') }}</textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@isset($record)
    @if($record->participants->isNotEmpty())
        <hr>
        <h5 class="mb-2">参加者一覧</h5>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>氏名</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($record->participants as $i => $participant)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $participant->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endisset
