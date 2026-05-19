<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only logged-in customers can place orders
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'delivery_name'    => ['required', 'string', 'max:100'],
            'delivery_phone'   => ['required', 'string', 'max:15', 'regex:/^[0-9]{10}$/'],
            'delivery_address' => ['required', 'string', 'max:500'],
            'delivery_city'    => ['required', 'string', 'max:100'],
            'delivery_state'   => ['required', 'string', 'max:100'],
            'delivery_pincode' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
            'payment_method'   => ['required', 'in:cod,razorpay,upi'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_phone.regex'   => 'Phone number must be 10 digits.',
            'delivery_pincode.size'  => 'Pincode must be exactly 6 digits.',
            'delivery_pincode.regex' => 'Pincode must contain only numbers.',
        ];
    }
}