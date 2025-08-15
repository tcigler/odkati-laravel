<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => ['required', 'integer'],
            'total_price' => ['required', 'integer'],
            'tour_id' => ['nullable', 'exists:tours'],
            'paid' => ['nullable', 'date'],
            'tour_title' => ['required'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
