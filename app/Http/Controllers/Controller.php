<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function responseSuccess(mixed $data = null)
    {
        $metadata = ['status' => '0000', 'desc'=>'Success'];
        $responseData = ['metadata' => $metadata, 'data' => $data];
        return response()->json($responseData, 200);
    }

    public function responseFail(mixed $data = null)
    {
        $metadata = ['status' => '9999', 'desc'=>'Fail'];
        $responseData = ['metadata' => $metadata, 'data' => $data];
        return response()->json($responseData, 400);
    }

    public function responseNotfound(mixed $data = null)
    {
        $metadata = ['status' => '9999', 'desc'=>'Not Found'];
        $responseData = ['metadata' => $metadata, 'data' => $data];
        return response()->json($responseData, 404);
    }
}

