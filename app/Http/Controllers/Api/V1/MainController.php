<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MainController extends Controller
{

    /**
     * @param bool $success
     * @param int $statusCode
     * @param string $message
     * @param $result
     * @param array $headers
     * @return JsonResponse
     */
    public function easyResponse(bool $success, $result = null, int $statusCode = 200, string $message = "", array $headers = [])
    {
        return response()
            ->json([
                'status' => $success,
                'result' => $result,
                'message' => $message,
            ], $statusCode)
            ->withHeaders($headers);
    }
}
