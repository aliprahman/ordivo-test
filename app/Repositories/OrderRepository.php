<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Jobs\ProcessOrder;
use Illuminate\Http\Request;
use App\Interfaces\OrderInterface;
use App\Http\Requests\CheckoutRequest;

class OrderRepository implements OrderInterface {
    public function submitOrder(CheckoutRequest $request, $user_id) {
        $carts = Cart::with('product')->whereIn('id', $request->cart_ids)->get();
        $process = true;
        foreach ($carts as $item) {
            if ($item->quantity > $item->product->stock) {
                $process = false;
            }
        }

        if ($process) {
            ProcessOrder::dispatch($request->cart_ids, $user_id);
        }
        return $process;
    }
}
