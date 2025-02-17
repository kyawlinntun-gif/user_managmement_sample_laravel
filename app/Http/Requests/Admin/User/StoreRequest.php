<?php

namespace App\Http\Requests\Admin\User;

use App\Rules\NoSpecialChars;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'string', new NoSpecialChars],
            'username' => ['required', 'min:2', 'string'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'phone' => ['required', new PhoneNumber],
            'email' => ['required', 'email', 'unique:admin_users,email'],
            'password' => ['required', 'min:8', 'string', 'confirmed'],
            'address' => ['required', 'min:5', 'string'],
            'gender' => ['required', 'in:0,1'],
            'is_active' => ['required', 'in:0,1']
        ];
    }
}
