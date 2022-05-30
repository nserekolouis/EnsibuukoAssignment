<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class TestApiController extends Controller
{
    public function index($data, $message = "Ok", $paginated = false)
    {
        $this->status_code = $this->status_code ?? 200;
        return \Response::json([
            'status-code' => $this->status_code,
            'message' => 'Hello World!',
        ], $this->status_code);
    }
}
