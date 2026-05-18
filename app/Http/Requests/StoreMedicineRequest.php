<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
{
    /** Only admin and pharmacist can submit this form */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'pharmacist']);
    }

    public function rules(): array
    {
        return [
            'category_id'           => ['required', 'exists:categories,id'],
            'name'                  => ['required', 'string', 'max:200', 'unique:medicines,name'],
            'brand'                 => ['nullable', 'string', 'max:100'],
            'generic_name'          => ['nullable', 'string', 'max:200'],
            'description'           => ['nullable', 'string'],
            'price'                 => ['required', 'numeric', 'min:0'],
            'cost_price'            => ['nullable', 'numeric', 'min:0'],
            'discount'              => ['nullable', 'numeric', 'min:0', 'max:100'],
            'stock'                 => ['required', 'integer', 'min:0'],
            'min_stock_alert'       => ['nullable', 'integer', 'min:0'],
            'dosage'                => ['nullable', 'string', 'max:100'],
            'form'                  => ['nullable', 'in:tablet,capsule,syrup,injection,cream,drops,other'],
            'expiry_date'           => ['nullable', 'date', 'after:today'],
            'image'                 => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'requires_prescription' => ['boolean'],
            'is_active'             => ['boolean'],
        ];
    }

    /** Custom error messages */
    public function messages(): array
    {
        return [
            'category_id.required'  => 'Please select a category.',
            'category_id.exists'    => 'Selected category does not exist.',
            'name.unique'           => 'A medicine with this name already exists.',
            'price.required'        => 'Please enter the selling price.',
            'stock.required'        => 'Please enter the stock quantity.',
            'expiry_date.after'     => 'Expiry date must be a future date.',
            'image.max'             => 'Image size must not exceed 2MB.',
        ];
    }
}