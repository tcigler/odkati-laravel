<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionItemsRequest extends FormRequest {
    public function rules() {
        return ['transaction_id' => ['required', 'integer'], 'item_id' => ['required', 'exists:items'], 'quantity' => ['required', 'integer'],
        ];
    }

    public function authorize() {
        return true;
    }
}
