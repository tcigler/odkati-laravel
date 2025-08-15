<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemEan extends Model {
    public $timestamps = false;
    protected $fillable = ['ean', 'variant', 'item_id'];

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class);
    }

}
