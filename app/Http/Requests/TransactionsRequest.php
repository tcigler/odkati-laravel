<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionsRequest extends FormRequest {
    public function rules() {
        return ['finished' => ['required', 'integer'],
        ];
    }

    public function authorize() {
        return true;
    }
}
