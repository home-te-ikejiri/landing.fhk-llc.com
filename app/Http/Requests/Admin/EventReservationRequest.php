<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id'   => ['required', 'integer', 'exists:events,id'],
            'representative_name'  => ['required', 'max:100'],
            'email'               => ['required', 'email', 'max:255'],
            'representative_phone'=> ['required', 'max:20'],
            'num_participants'    => ['required', 'integer', 'min:1'],
            'message'    => ['nullable'],
            'status'     => ['required', 'integer', 'in:0,1,2'],
            'admin_memo' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'event_id'   => 'イベント',
            'representative_name'   => '代表者氏名',
            'email'                => 'メールアドレス',
            'representative_phone' => '代表者電話番号',
            'num_participants'     => '参加人数',
            'status'     => 'ステータス',
        ];
    }
}
