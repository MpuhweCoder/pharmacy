<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Both guests and logged-in users can add to cart
    }

    public function rules(): array
    {
        return [
            'medicine_id' => [
                'required',
                'integer',
                'exists:medicines,id', // medicine must exist
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:50', // prevent bulk buying abuse
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'medicine_id.exists'   => 'This medicine does not exist.',
            'quantity.min'         => 'Quantity must be at least 1.',
            'quantity.max'         => 'You cannot add more than 50 units at once.',
        ];
    }
}