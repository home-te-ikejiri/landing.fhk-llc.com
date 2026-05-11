<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\RentalRoomReservation;

class RentalRoomReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reservation_date' => ['required', 'date_format:Y-m-d'],
            'start_time'       => ['required', 'integer', 'between:10,17'],
            'end_time'         => ['required', 'integer', 'between:11,18', 'gt:start_time'],
            'usage_type'       => ['required', 'integer', 'in:0,1'],
            'purpose'          => ['required', 'integer', 'in:0,1,2,3,4'],
            'num_people'       => ['required', 'integer', 'min:1', 'max:50'],
            'name'             => ['required', 'string', 'max:100'],
            'email'            => ['required', 'email', 'max:255'],
            'phone'            => ['required', 'string', 'max:20', 'regex:/^[0-9\-\(\)\+]{10,20}$/'],
            'message'          => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'reservation_date' => '予約日',
            'start_time'       => '開始時間',
            'end_time'         => '終了時間',
            'usage_type'       => '利用種別',
            'purpose'          => '利用目的',
            'num_people'       => '利用人数',
            'name'             => 'お名前',
            'email'            => 'メールアドレス',
            'phone'            => '電話番号',
            'message'          => '通信欄',
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.gt'    => '終了時間は開始時間より後を選択してください。',
            'phone.regex'    => '電話番号は半角数字・ハイフンで入力してください（例：026-000-0000）。',
        ];
    }

    /**
     * 占有予約の場合、選択時間帯に既存予約がないか確認する
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ((int) $this->input('usage_type') !== RentalRoomReservation::USAGE_TYPE_EXCLUSIVE) {
                return;
            }

            $date  = $this->input('reservation_date');
            $start = $this->input('start_time');
            $end   = $this->input('end_time');

            if (!$date || !is_numeric($start) || !is_numeric($end)) {
                return;
            }

            $exists = RentalRoomReservation::where('reservation_date', $date)
                ->whereIn('status', [
                    RentalRoomReservation::STATUS_TENTATIVE,
                    RentalRoomReservation::STATUS_CONFIRMED,
                ])
                ->where('start_time', '<', sprintf('%02d:00:00', (int) $end))
                ->where('end_time',   '>', sprintf('%02d:00:00', (int) $start))
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'usage_type',
                    'この時間帯にはすでに予約が入っているため、占有での予約はできません。'
                );
            }
        });
    }
}
