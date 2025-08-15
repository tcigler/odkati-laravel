<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItems extends Model {

    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['transaction_id', 'item_id', 'quantity', 'price_per_unit'];

    public function item() {
        return $this->belongsTo(Item::class);
    }
}
