<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'mobile' => ['required', 'digits:10'],
            'address' => ['required', 'string', 'max:1000'],
            'hub_id' => ['required', 'exists:hubs,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'delivery_fee' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
