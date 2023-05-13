<?php

namespace App\Interfaces;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

interface UserInterface {
    public function register(RegisterRequest $request);
    public function login(LoginRequest $request);
}
