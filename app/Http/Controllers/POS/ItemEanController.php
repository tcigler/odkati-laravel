<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\ItemEan;
use Illuminate\Http\Request;

class ItemEanController extends Controller {

    public function get($ean) {
        return ItemEan::where('ean', $ean)->firstOrFail();
    }

    public function upsert($ean, $variant, $itemId) {
        $itemEan = ItemEan::where('ean', $ean)->firstOrNew([
            'ean' => $ean,
            'variant' => $variant,
            'item_id' => $itemId
        ]);
        return $itemEan->save();
    }

    public function destroy($ean) {
        return ItemEan::where('ean', $ean)->delete();
    }
}
