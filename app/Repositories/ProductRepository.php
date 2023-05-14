<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Interfaces\ProductInterface;
use App\Http\Requests\ProductRequest;

class ProductRepository implements ProductInterface {
    public function list(Request $request) {
        $search = $request->query('search', '');
        $minPrice = $request->query('min_price', 0);
        $maxPrice = $request->query('max_price', 0);
        return Product::when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%");
        })->when($minPrice, function ($query, $minPrice) {
            $query->where('price', '>=', $minPrice);
        })->when($maxPrice, function ($query, $maxPrice) {
            $query->where('price', '<=', $maxPrice);
        })
        ->paginate($request->per_page);
    }

    public function detail($id) {
        return Product::find($id);
    }

    public function create(ProductRequest $request) {
        return Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock
        ]);
    }

    public function update($id, ProductRequest $request) {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        return $product;
    }

    public function delete($id) {
        return Product::destroy($id);
    }
}
