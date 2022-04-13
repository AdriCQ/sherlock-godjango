<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($data = null, $message = null, int $status = 200)
    {
        return response()->json(['data' => $data, 'message' => $message], $status, [], JSON_NUMERIC_CHECK);
    }

    public function sendAuthError()
    {
        return $this->sendResponse(null, null, 401);
    }
}
