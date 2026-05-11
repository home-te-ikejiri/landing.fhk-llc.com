<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShopScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'month'          => ['required', 'date_format:Y-m'],
            'schedules'      => ['required', 'array'],
            'schedules.*.date'   => ['required', 'date_format:Y-m-d'],
            'schedules.*.status' => ['required', 'integer', 'in:0,1,2'],
            'schedules.*.memo'   => ['nullable', 'max:255'],
        ];
    }
}
