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
            'name'    => ['required', 'string', 'max:100'],
            'kana'    => ['nullable', 'string', 'max:100', 'regex:/^[ぁ-んー　 ]+$/u'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20', 'regex:/^[0-9\-\(\)\+]{10,20}$/'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'    => 'お名前',
            'kana'    => 'ふりがな',
            'email'   => 'メールアドレス',
            'phone'   => '電話番号',
            'message' => 'お問い合わせ内容',
        ];
    }

    public function messages(): array
    {
        return [
            'kana.regex'  => 'ふりがなはひらがなで入力してください。',
            'phone.regex' => '電話番号は半角数字・ハイフンで入力してください（例：026-000-0000）。',
        ];
    }
}
