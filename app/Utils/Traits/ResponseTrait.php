<?php

namespace App\Utils\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait {
    public function responseSuccess ($message = 'success', $data = []) {
        return new JsonResponse([
            'result' => true,
            'message' => $message,
            'data'   => $data,
        ],200);
    }

    public function responseError($message = 'error', $status = 500) {
        return new JsonResponse([
            'result' => false,
            'message' => $message,
        ],$status);
    }
}
