<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("transaction_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("item_id")->nullable()->constrained(table: "items")->nullOnDelete()->cascadeOnUpdate();
            $table->tinyText("item_name");
//            $table->json("item_json")->nullable();
            $table->integer("quantity")->default(1);
            $table->integer("price_per_unit");
        });
    }

    public function down() {
        Schema::dropIfExists('transaction_items');
    }
};
