<?php

namespace App\Policies;

use App\Models\ItemStock;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemStockPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user): bool {
        return true;
    }

    public function view(User $user, ItemStock $itemStock): bool {
        return true;
    }

    public function create(User $user): bool {
        return true;
    }

    public function update(User $user, ItemStock $itemStock): bool {
        return true;
    }

    public function delete(User $user, ItemStock $itemStock): bool {
        return true;
    }

    public function restore(User $user, ItemStock $itemStock): bool {
        return true;
    }

    public function forceDelete(User $user, ItemStock $itemStock): bool {
        return true;
    }
}
