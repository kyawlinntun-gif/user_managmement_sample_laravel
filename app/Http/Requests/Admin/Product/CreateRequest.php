<?php

namespace App\Http\Requests\Admin\Product;

use App\Rules\NoSpecialChars;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
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
            'product_name' => ['required', 'min:3', 'string', new NoSpecialChars],
            'description' => ['required', 'min:3', 'string'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,gif', 'max:5120']
        ];
    }
}
