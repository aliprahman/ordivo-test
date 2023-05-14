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

    public function listOrder(Request $request, $user_id) {
        $search = $request->query('search', '');
        $minDate = $request->query('min_date', '');
        $maxDate = $request->query('max_date', '');
        return Order::with('order_details')
        ->where('user_id', $user_id)
        ->when($search, function ($query, $search) {
            $query->where('order_code', 'like', "%$search%");
        })
        ->when($minDate, function ($query, $minDate) {
            $query->whereDate('created_at', '>=', $minDate);
        })->when($maxDate, function ($query, $maxDate) {
            $query->whereDate('created_at', '<=', $maxDate);
        })
        ->paginate($request->per_page);
    }
}
