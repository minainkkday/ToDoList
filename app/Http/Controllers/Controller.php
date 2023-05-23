<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    //Add two parameters, user login fail case!
    public function responseSuccess(mixed $data = null, string $status = '0000', string $desc = 'Success')
    {
        $metadata = ['status' => $status , 'desc'=> $desc];
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

