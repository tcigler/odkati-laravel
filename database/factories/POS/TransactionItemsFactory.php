<?php

namespace database\factories\POS;

use App\Models\POS\Item;
use App\Models\POS\Transaction;
use App\Models\POS\TransactionItems;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionItemsFactory extends Factory {
    protected $model = TransactionItems::class;

    public function definition(): array {
        return [
            'transaction_id' => Transaction::inRandomOrder()->first()->id,
//            'item_json' => json_encode(["name" => $this->faker->word(), "price" => $this->faker->randomNumber(3)]),
            'item_name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 20),
            'price_per_unit' => $this->faker->numberBetween(5, 500),
            'item_id' => Item::inRandomOrder()->first()->id,
        ];
    }
}
