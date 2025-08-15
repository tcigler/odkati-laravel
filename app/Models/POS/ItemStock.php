<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model {
    protected $table = 'item_stock';

    protected $fillable = [
        'item_id',
        'original_price',
        'quantity',
    ];
}
