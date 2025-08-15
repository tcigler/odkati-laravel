<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->tinyText('name');
            $table->integer('price');
            $table->integer('quantity')->default(0); # FIXME deprecated
            $table->integer('original_price')->nullable(); # FIXME deprecated
            $table->string("ean")->nullable(); # FIXME deprecated!
            $table->timestamps();
        });

        Schema::create('item_eans', function (Blueprint $table) {
            $table->string('ean', 64)->primary();
            $table->tinyText('variant')->nullable();
            $table->foreignId('item_id')->constrained('items')
                ->onUpdate('cascade')->onDelete('cascade');

        });
    }

    public function down() {
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_eans');
    }
};
