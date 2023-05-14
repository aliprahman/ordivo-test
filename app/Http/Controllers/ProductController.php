<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Traits\ResponseTrait;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;


class ProductController extends Controller
{
    use ResponseTrait;

    protected $productRepository;

    function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request) {
        $products = $this->productRepository->list($request);
        return (new ProductCollection($products))->additional([
            'message' => count($products) ? 'get product success' : 'empty product'
        ]);
    }

    public function show($id){
        $product = $this->productRepository->detail($id);
        if ($product) {
            return $this->responseSuccess('get product success', new ProductResource($product));
        } else {
            return $this->responseError('product not found');
        }
    }

    public function store(ProductRequest $request){
        $product = $this->productRepository->create($request);
        if ($product) {
            return $this->responseSuccess('create product success', new ProductResource($product));
        } else {
            return $this->responseError('create product failed');
        }
    }

    public function update($id, ProductRequest $request){
        $product = $this->productRepository->detail($id);
        if ($product) {
            $updated = $this->productRepository->update($id, $request);
            return $this->responseSuccess('update product success', new ProductResource($updated));
        } else {
            return $this->responseError('product not found');
        }
    }

    public function destroy($id){
        $product = $this->productRepository->detail($id);
        if ($product) {
            $this->productRepository->delete($id);
            return $this->responseSuccess('delete product success');
        } else {
            return $this->responseError('product not found');
        }
    }
}
