<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckUserApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->permission==1){
            return $next($request);
        }
        return response()->json([
            'status'=>'error',
            'content'=>'that bai',
            'data'=>'Bạn chưa được cấp quyền truy cập'
        ],401);
    }
}
