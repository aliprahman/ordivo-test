<?php

namespace App\Http\Controllers;

use App\Utils\ResponseTrait;
use App\Repositories\UserRepository;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    protected $userRepository;

    function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function signUp(RegisterRequest $request)
    {
        $user = $this->userRepository->register($request);
        if ($user) {
            return $this->responseSuccess('register success', $user);
        } else {
            return $this->responseError('register failed');
        }
    }

    public function signIn(LoginRequest $request)
    {
        $user = $this->userRepository->login($request);
        if ($user) {
            return $this->responseSuccess('login success', $user);
        } else {
            return $this->responseError('email or password not valid');
        }
    }
}
