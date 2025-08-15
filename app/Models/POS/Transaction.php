<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model {
    use HasFactory;

    public function items(): HasMany {
        return $this->hasMany(TransactionItems::class);
    }
}
