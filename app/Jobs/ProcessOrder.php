<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cart_ids;

    public $user_id;

    /**
     * Create a new job instance.
     */
    public function __construct($cart_ids, $user_id)
    {
        $this->cart_ids = $cart_ids;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        try {
            $carts = Cart::with('product')->whereIn('id', $this->cart_ids)->get();
            $total_quantity = 0;
            $total_price = 0;
            foreach ($carts as $item) {
                $total_price += $item->product->price;
                $total_quantity += $item->quantity;
            }

            $order = Order::create([
                'user_id' => $this->user_id,
                'total_price' => $total_price,
                'total_quantity' => $total_quantity
            ]);

            foreach ($carts as $item) {
                // save detail order
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity
                ]);
                // decrement stock product
                $product = Product::find($item->product->id);
                $product->stock = $product->stock - $item->quantity;
                $product->save();
            }

            Cart::destroy($this->cart_ids);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
