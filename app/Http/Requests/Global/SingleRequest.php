<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SingleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required']
        ];
    }
}
