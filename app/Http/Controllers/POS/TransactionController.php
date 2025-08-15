<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Item;
use App\Models\POS\ItemEan;
use App\Models\POS\Transaction;
use App\Models\POS\TransactionItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller {
    public function index() {
        $tx = Transaction::all()->sortByDesc('created_at');
        return inertia("Tx/Index", ["transactions" => $tx]);
    }

    public function create($tx_id) {
        $tx = Transaction::findOrFail($tx_id);
        return inertia("Tx/Create", ["transaction" => $tx, "transaction_items" => $tx->items]);
    }

    public function store() {
        $tx = Transaction::create();
        return redirect(route("tx.create", $tx->id));
    }

    public function show(Transaction $tx) {
        return inertia("Tx/Show", ["transaction" => $tx, "transaction_items" => $tx->items]);
    }

    public function addItem($tx_id, $item_id, $quantity) {
        $item = Item::findOrFail($item_id);
        $tx = Transaction::findOrFail($tx_id);

        $txItem = TransactionItems::where("transaction_id", $tx->id)->where("item_id", $item->id)->first();
        if($txItem == null) {
            $txItem = new TransactionItems();
            $txItem->quantity = $quantity;
            $txItem->item_id = $item->id;
            $txItem->item_name = $item->name;
            $txItem->price_per_unit = $item->price;
            $txItem->transaction_id = $tx->id;
        } else {
            $txItem->quantity = $txItem->quantity + $quantity;
        }

        $txItem->save();
        return $txItem;
    }

    public function updateQuantity($tx_item_id, $quantity) {
        Log::debug("TX ID: " . $tx_item_id . " quantity: " . $quantity);
        $txItem = TransactionItems::findOrFail($tx_item_id);
        $txItem->quantity = $quantity;
        $txItem->save();
    }

    public function removeItem($tx_item_id) {
        return TransactionItems::destroy($tx_item_id);
    }

    public function edit($id) {}

    public function update(Request $request, Transaction $tx) {
        $tx->finished = true;
        $tx->note = $request->input("note");
        $tx->save();
        return redirect(route("tx.show", $tx->id));
    }

}
