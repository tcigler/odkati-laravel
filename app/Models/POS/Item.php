<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model {

    use HasFactory;

    protected $fillable = ['id', 'name', 'quantity', 'price', 'original_price'];

    public function eans(): HasMany {
        return $this->hasMany(ItemEan::class, 'item_id', 'id');
    }
}
