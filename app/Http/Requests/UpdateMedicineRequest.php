<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'pharmacist']);
    }

    public function rules(): array
    {
        // Ignore current medicine's name in unique check
        $medicineId = $this->route('medicine')->id;

        return [
            'category_id'           => ['required', 'exists:categories,id'],
            'name'                  => ['required', 'string', 'max:200', "unique:medicines,name,{$medicineId}"],
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
            'expiry_date'           => ['nullable', 'date'],
            'image'                 => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'requires_prescription' => ['boolean'],
            'is_active'             => ['boolean'],
        ];
    }
}