<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Show success response
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($code, $data = null) {
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], $code);
    }

}
