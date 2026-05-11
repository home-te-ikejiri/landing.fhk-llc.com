<?php

namespace App\Http\Requests\Admin;

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
            'status'     => ['required', 'integer', 'in:0,1,2'],
            'admin_memo' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'ステータス',
        ];
    }
}
