<?php

namespace App\Http\Requests\Admin\Feature;

use App\Rules\NoSpecialChars;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role_id ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'feature_name' => ['required', 'min:3', 'string', new NoSpecialChars, Rule::unique('features', 'name')->ignore($this->route('id'))]
        ];
    }
}
