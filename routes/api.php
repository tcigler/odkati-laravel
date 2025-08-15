<?php

use App\Http\Controllers\POS\ItemEanController;
use App\Http\Controllers\POS\ItemsController;
use App\Http\Controllers\POS\TransactionController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const KEY_HASH="ad490e47a66386a3082ec1f8fa126da3e6f13db22f0c95dde423f3a1f884b9ad";
const ADMIN_PASS_HASH="$2y$12$2j.KBAwPP2GKHNm9wG4WNOUVkA6P2UfWRux8asgO9Kt.s8CSDCQmu";

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/items/find/{ean}", [ItemsController::class, 'find'])->name('items.find');
Route::get("/items/get/{id}", [ItemsController::class, 'get'])->name('items.get');

Route::get("/item-ean/{ean}", [ItemEanController::class, 'get'])->name('item-ean.get');
Route::delete("/item-ean/destroy/{ean}", [ItemEanController::class, 'destroy'])->name('item-ean.destroy');

Route::put("/transaction/{transaction_id}/add-item/{item_id}/{quantity}", [TransactionController::class, 'addItem'])->name('transaction-item.add');
Route::put("/transaction-item/{tx_item_id}/update/{quantity}", [TransactionController::class, 'updateQuantity'])->name('transaction-item.update');
Route::delete("/transaction-item/{tx_item_id}/destroy", [TransactionController::class, 'removeItem'])->name('transaction-item.destroy');

Route::get('/db-init', function (Request $request) {
    $key = $request->get("key", "test");
    if(hash('sha256', $key) == KEY_HASH) {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin";
        // Disable the hashed cast temporarily
        $user->mergeCasts([
            'password' => 'string', // Treat it as a plain string
        ]);

        $user->password = ADMIN_PASS_HASH;
        $user->current_team_id = 1;
        $user->save();
    }
});

Route::get('/run-migrations', function (Request $request) {

    $key = $request->get("key", "test");
    if(hash('sha256', $key) == KEY_HASH) {
        $seed = $request->get("seed", "false");
        $fresh = $request->get("fresh", "false");
        $pretend = $request->get("pretend", "false");
        $admin = $request->get("admin", "false");

        try {
            $params = ["--database" => "main_admin"];
            if($seed == "true") {
                $params["--seed"] = "true";
            }
            if($pretend == "true") {
                $params["--pretend"] = "true";
            }
            Artisan::call(($fresh == "true") ? 'migrate:fresh' : 'migrate', $params);

            if($admin == "true") {
                $user = new User();
                $user->name = "Admin";
                $user->email = "admin";

                // Disable the hashed cast temporarily
                $user->mergeCasts([
                    'password' => 'string', // Treat it as a plain string
                ]);

                $user->password = ADMIN_PASS_HASH;
                $user->current_team_id = 1;
                $user->save();
            }

            return Artisan::output();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } else {
        abort(404);
    }

});
