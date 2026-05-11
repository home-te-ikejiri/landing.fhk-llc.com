<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'max:255'],
            'event_date'   => ['required', 'date_format:Y-m-d'],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'capacity'     => ['required', 'integer', 'min:1'],
            'description'  => ['nullable'],
            'price'        => ['required', 'integer', 'min:0'],
            'external_url' => ['nullable', 'url', 'max:500'],
            'status'       => ['required', 'integer', 'in:0,1,2'],
            'admin_memo'   => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'        => 'イベントタイトル',
            'event_date'   => '開催日',
            'start_time'   => '開始時間',
            'end_time'     => '終了時間',
            'capacity'     => '定員',
            'price'        => '参加費',
            'external_url' => '外部申込URL',
            'status'       => 'ステータス',
        ];
    }
}
