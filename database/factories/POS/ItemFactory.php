<?php

namespace database\factories\POS;

use App\Models\POS\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ItemFactory extends Factory {
    protected $model = Item::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(10, 200),
            'quantity' => $this->faker->numberBetween(1, 20),
            'original_price' => $this->faker->numberBetween(10, 200),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
