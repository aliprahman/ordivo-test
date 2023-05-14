<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Requests\DeleteCartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartCollection;
use App\Utils\Traits\ResponseTrait;
use App\Repositories\CartRepository;

class CartController extends Controller
{
    use ResponseTrait;

    protected $cartRepository;

    function __construct(CartRepository $cartRepository) {
        $this->cartRepository = $cartRepository;
    }

    public function index(Request $request) {
        $carts = $this->cartRepository->list($request, $request->user()->id);
        return (new CartCollection($carts))->additional([
            'message' => count($carts) ? 'get cart success' : 'empty cart'
        ]);
    }

    public function store(CartRequest $request) {
        $product = $this->cartRepository->add($request, $request->user()->id);
        if ($product) {
            return $this->responseSuccess('add product to cart success', new CartResource($product));
        } else {
            return $this->responseError('add product to cart failed');
        }
    }

    public function destory(DeleteCartRequest $request) {
        $this->cartRepository->delete($request->cart_ids);
        return $this->responseSuccess('delete cart success');
    }
}
