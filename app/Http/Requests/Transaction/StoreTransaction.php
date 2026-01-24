<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaction extends FormRequest
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
            'borrowed_at' => 'required|date',
            'due_at'      => 'required|date|after_or_equal:borrowed_at',

            'items'           => 'required|array|min:1',
            'items.*.book_id' => 'required|exists:books,id',
            'items.*.quantity'     => 'required|integer|min:1',
        ];
    }

}
