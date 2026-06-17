<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RentalRoomTimeSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'               => ['required', 'date_format:Y-m-d'],
            'slots'              => ['required', 'array'],
            'slots.*.hour'       => ['required', 'integer', 'min:10', 'max:17'], // 管理対象時間帯に合わせて変更
            'slots.*.is_blocked' => ['required', 'integer', 'in:0,1'],
            'slots.*.admin_memo' => ['nullable', 'max:255'],
        ];
    }
}
