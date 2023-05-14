<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

interface ProductInterface {
    public function list(Request $request);
    public function detail($id);
    public function create(ProductRequest $request);
    public function update($id, ProductRequest $request);
    public function delete($id);
}
