<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('item_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId("item_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal("original_price");
            $table->integer("quantity");
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('item_stock');
    }
};
