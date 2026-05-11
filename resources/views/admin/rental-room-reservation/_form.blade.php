{{-- レンタルルーム予約フォームの共通パーツ --}}
<div class="table-responsive">
    <table class="table text-nowrap table-register">
        <tbody>
            <tr>
                <th scope="row" width="180">予約日<span class="req"></span></th>
                <td>
                    @error('reservation_date') <span class="error-message">{{ $message }}</span> @enderror
                    <div class="w-25">
                        <input type="date" class="form-control" name="reservation_date"
                               value="{{ old('reservation_date', isset($record) ? $record->reservation_date->format('Y-m-d') : '') }}">
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">開始時間<span class="req"></span></th>
                <td>
                    @error('start_time') <span class="error-message">{{ $message }}</span> @enderror
                    <div class="w-25">
                        <input type="time" class="form-control" name="start_time"
                               value="{{ old('start_time', isset($record) ? substr($record->start_time, 0, 5) : '') }}">
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">終了時間<span class="req"></span></th>
                <td>
                    @error('end_time') <span class="error-message">{{ $message }}</span> @enderror
                    <div class="w-25">
                        <input type="time" class="form-control" name="end_time"
                               value="{{ old('end_time', isset($record) ? substr($record->end_time, 0, 5) : '') }}">
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">利用種別<span class="req"></span></th>
                <td>
                    @error('usage_type') <span class="error-message">{{ $message }}</span> @enderror
                    <select name="usage_type" class="form-control w-50">
                        @foreach($usageTypeLabels as $val => $label)
                            <option value="{{ $val }}" {{ old('usage_type', $record->usage_type ?? 0) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">利用目的<span class="req"></span></th>
                <td>
                    @error('purpose') <span class="error-message">{{ $message }}</span> @enderror
                    <select name="purpose" class="form-control w-50">
                        @foreach($purposeLabels as $val => $label)
                            <option value="{{ $val }}" {{ old('purpose', $record->purpose ?? 0) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">利用人数<span class="req"></span></th>
                <td>
                    @error('num_people') <span class="error-message">{{ $message }}</span> @enderror
                    <div class="w-25">
                        <div class="input-group">
                            <input type="number" class="form-control" name="num_people" min="1"
                                   value="{{ old('num_people', $record->num_people ?? '') }}">
                            <div class="input-group-append"><span class="input-group-text">名</span></div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">氏名<span class="req"></span></th>
                <td>
                    @error('name') <span class="error-message">{{ $message }}</span> @enderror
                    <input type="text" class="form-control" name="name"
                           value="{{ old('name', $record->name ?? '') }}">
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
                <th scope="row">電話番号<span class="req"></span></th>
                <td>
                    @error('phone') <span class="error-message">{{ $message }}</span> @enderror
                    <input type="tel" class="form-control w-50" name="phone"
                           value="{{ old('phone', $record->phone ?? '') }}">
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
