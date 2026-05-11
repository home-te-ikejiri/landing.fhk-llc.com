<?php

namespace App\Http\Requests\User;

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
            'event_id'             => ['required', 'integer', 'exists:events,id'],
            'num_participants'      => ['required', 'integer', 'min:1'],
            'representative_name'  => ['required', 'string', 'max:100'],
            'representative_phone' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\(\)\+]{10,20}$/'],
            'email'                => ['required', 'email', 'max:255'],
            'message'              => ['nullable', 'string', 'max:2000'],
            'participants'         => ['required', 'array', 'min:1'],
            'participants.*'       => ['required', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'event_id'             => 'イベント',
            'num_participants'     => '参加人数',
            'representative_name'  => '代表者氏名',
            'representative_phone' => '代表者電話番号',
            'email'                => 'メールアドレス',
            'message'              => '通信欄',
            'participants'         => '参加者名',
            'participants.*'       => '参加者名',
        ];
    }

    public function messages(): array
    {
        return [
            'representative_phone.regex' => '電話番号は半角数字・ハイフンで入力してください（例：026-000-0000）。',
            'participants.*.required'    => '参加者名を入力してください。',
        ];
    }
}
