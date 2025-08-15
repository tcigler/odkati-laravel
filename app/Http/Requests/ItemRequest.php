<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest {
    public function rules() {
        return ['ean' => ['required', 'integer'], 'name' => ['required'], 'quantity' => ['required', 'integer'], 'price' => ['required', 'integer'], 'original_price' => ['nullable', 'integer'],
        ];
    }

    public function authorize() {
        return true;
    }
}
