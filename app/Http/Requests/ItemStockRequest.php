<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStockRequest extends FormRequest {
    public function rules(): array {
        return [
            'item_id' => ['required', 'integer'],
            'original_price' => ['required', 'numeric'],
            'quantity' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
