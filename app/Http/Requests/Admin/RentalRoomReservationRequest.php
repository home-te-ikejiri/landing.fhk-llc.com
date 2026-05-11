<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
            'start_time'       => ['required', 'date_format:H:i'],
            'end_time'         => ['required', 'date_format:H:i', 'after:start_time'],
            'usage_type'       => ['required', 'integer', 'in:0,1'],
            'purpose'          => ['required', 'integer', 'in:0,1,2,3,4'],
            'num_people'       => ['required', 'integer', 'min:1'],
            'name'             => ['required', 'max:100'],
            'email'            => ['required', 'email', 'max:255'],
            'phone'            => ['required', 'max:20'],
            'message'          => ['nullable'],
            'status'           => ['required', 'integer', 'in:0,1,2,3'],
            'admin_memo'       => ['nullable'],
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
            'name'             => '氏名',
            'email'            => 'メールアドレス',
            'phone'            => '電話番号',
            'status'           => 'ステータス',
        ];
    }
}
