<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:100'],
            'kana'             => ['nullable', 'string', 'max:100', 'regex:/^[ぁ-んー　 ]+$/u'],
            'email'            => ['required', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:20', 'regex:/^[0-9\-\(\)\+]{10,20}$/'],
            'related_type'     => ['nullable', 'string', 'in:rental_room_reservation,event_reservation,other'],
            'related_id_input' => ['nullable', 'integer', 'min:1'],
            'message'          => ['required', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'             => 'お名前',
            'kana'             => 'ふりがな',
            'email'            => 'メールアドレス',
            'phone'            => '電話番号',
            'related_type'     => 'お問い合わせ種別',
            'related_id_input' => '予約番号',
            'message'          => 'お問い合わせ内容',
        ];
    }

    public function messages(): array
    {
        return [
            'kana.regex'              => 'ふりがなはひらがなで入力してください。',
            'phone.regex'             => '電話番号は半角数字・ハイフンで入力してください（例：026-000-0000）。',
            'related_type.in'         => 'お問い合わせ種別の値が不正です。',
            'related_id_input.integer' => '予約番号は半角数字で入力してください。',
        ];
    }
}
