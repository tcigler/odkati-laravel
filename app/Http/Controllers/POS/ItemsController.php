<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Item;
use App\Models\POS\ItemEan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Nette\Utils\Random;

class ItemsController extends Controller {
    public function index() {

        $items = Item::all();

        return inertia('Items/Index', ['items' => $items]);
    }

    public function index2() {

        $items = Item::all();

        return inertia('Items/Index2', ['items' => $items]);
    }

    public function create(Request $request) {
        return inertia('Items/Create', ['ean' => $request->input('ean', '')]);
    }

    public function store(Request $request) {

//        $rand = rand(1,100000);
//        $item = new Item();
        $item = Item::create(
            $request->validate([
                'eans' => 'required|array',
                'name' => 'required',
                'quantity' => 'required|min:1|max:10000',
                'price' => 'required|min:1|max:10000',
            ])
        );

//        $item->ean = $rand;
//        $item->name = "test item " . $rand;
//        $item->quantity = 1;
//        $item->price = 10;
//        $item->original_price = 9;
//
//        $item->save();

        $eans = $request->input('eans');
        foreach ($eans as $eanModel) {
            $ean = $eanModel['ean'] ?? "";
            if(!empty($ean)) {
                $this->upsertEan($ean, $eanModel['variant'] ?? null, $item->id);
            }
        }

        return Redirect::route("items.index");

    }

    public function show(Item $item) {
        return inertia('Items/Show', [
            'item' => $item,
            'eans' => $item->eans //ItemEan::where('item_id', 1)->get()
        ]);
    }

    public function find(String $ean) {
        return ItemEan::where('ean', $ean)->firstOrFail();

//        return inertia('Items/Show', [
//            'item' => $eanObject->item,
//            //'eans' => $item->eans //ItemEan::where('item_id', 1)->get()
//        ]);
    }

    public function search() {
        return inertia( 'Items/Search', []);
    }

    public function edit(Item $item) {
        return inertia( 'Items/Edit', [
            "item" => $item,
            "eans" => $item->eans
        ]);
    }

    public function get($id) {
        return Item::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $item = Item::findOrFail($id);
        $item->update($request->validate([
            'eans' => 'required|array',
            'name' => 'required',
            'quantity' => 'required|min:1|max:10000',
            'price' => 'required|min:1|max:10000',
        ]));

        $eans = $request->get('eans');
        foreach ($eans as $eanModel) {
            $ean = $eanModel['ean'];
            if(!empty($ean))
            $this->upsertEan($ean, $eanModel['variant'] ?? null, $id);
        }

        return Redirect::route("items.index");
    }

    private function upsertEan($ean, $variant, $itemId) {
        $itemEan = ItemEan::where('ean', $ean)->firstOrNew([
            'ean' => $ean,
            'variant' => $variant,
            'item_id' => $itemId
        ]);
        return $itemEan->save();
    }

    public function destroy($id) {
        Item::findOrFail($id)->delete();
        return redirect()->back();
    }
}
