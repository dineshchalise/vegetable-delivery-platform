<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkPriceUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'prices' => ['required', 'array', 'min:1'],
            'prices.*.product_id' => ['required', 'exists:products,id'],
            'prices.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
