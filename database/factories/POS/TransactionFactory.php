<?php

namespace database\factories\POS;

use App\Models\POS\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionFactory extends Factory {
    protected $model = Transaction::class;

    public function definition(): array {
        return [
            'finished' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
