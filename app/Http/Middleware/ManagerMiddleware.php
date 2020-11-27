<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //로그인 여부 체크 및 메니저 권한체크 (10부터)
        if(!Auth::check()){
            return redirect()->route('auth.login');
        }else if(10 <= Auth::user()->grade){
            return $next($request);
        }

        //권한없는 사용자인 경우
        return redirect('memo')->send();
    }
}
