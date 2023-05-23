<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // 사용자가 로그인한 경우 다음 요청으로 진행합니다.
            return $next($request);
        }

        //401 未認證    
        $metadata = ['status' => 'AUTH_0002' , 'desc'=> 'Unauthrozied Approach'];
        $responseData = ['metadata' => $metadata, 'data' => false];
        return response()->json($responseData, 401);
    }
}
