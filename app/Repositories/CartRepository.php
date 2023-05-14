<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Interfaces\CartInterface;
use App\Http\Requests\CartRequest;

class CartRepository implements CartInterface {
    public function list(Request $request, $user_id) {
        $search = $request->query('search', '');
        return Cart::where('user_id', $user_id)
        ->with(['product' => function ($query) use ($search) {
            $query->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%");
            });
        }])
        ->paginate($request->per_page);
    }


    public function add(CartRequest $request, $user_id) {
        return Cart::updateOrCreate(
            ['user_id' => $user_id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity],
        );
    }

    public function delete(array $ids) {
        return Cart::destroy($ids);
    }
}
