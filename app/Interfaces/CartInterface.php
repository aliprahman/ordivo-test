<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;

interface CartInterface {
    public function add(CartRequest $request, $user_id);
    public function list(Request $request, $user_id);
    public function delete($ids);
}
