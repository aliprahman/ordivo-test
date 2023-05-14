<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;

interface OrderInterface {
    public function submitOrder(CheckoutRequest $request, $user_id);
    public function listOrder(Request $request, $user_id);
    public function summary();
}
