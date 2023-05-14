<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Traits\ResponseTrait;
use App\Http\Requests\CheckoutRequest;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    use ResponseTrait;

    protected $orderRepository;

    function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function checkout(CheckoutRequest $request) {
        $result = $this->orderRepository->submitOrder($request, auth()->user()->id);
        if ($result) {
            return $this->responseSuccess('checkout success');
        } else {
            return $this->responseError('checkout failed');
        }
    }
}
