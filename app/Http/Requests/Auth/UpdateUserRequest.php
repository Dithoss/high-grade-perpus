<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:3',
            'email' => [
                'sometimes',
                'email',
                Rule::unique(User::class, 'email')->ignore(
                    $this->route('id') ?? $this->route('user_panel') ?? $this->route('user')
                ),
            ],
            'password' => 'nullable|string|min:8', // Changed from 'sometimes' to 'nullable'
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2893',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Nama minimal 3 karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau JPEG.',
            'image.max' => 'Ukuran gambar maksimal 2.8 MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->password === null || $this->password === '') {
            $this->request->remove('password');
        }
    }
}