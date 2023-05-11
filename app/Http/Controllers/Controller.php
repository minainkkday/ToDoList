<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function responseSuccess($data = null){
        $metadata = ['status' => '0000', 'desc'=>'Success'];
        $responseData = ['metadata' => $metadata, 'data' => $data];
        return response()->json($responseData, 200);
    }

    public function responseFail($data = null){
        $metadata = ['status' => '0001', 'desc'=>'Fail'];
        $responseData = ['metadata' => $metadata, 'data' => $data];
        return response()->json($responseData, 400);
    }

    public function responseNotfound($data = null){
        $metadata = ['status' => '0002', 'desc'=>'Not Found'];
        $responseData = ['metadata' => $metadata, 'data' => $data];
        return response()->json($responseData, 404);
    }
}

