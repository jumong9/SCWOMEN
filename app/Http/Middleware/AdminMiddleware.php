<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){

        //로그인 여부 체크 및 관리자 권한체크
        if(!Auth::check()){
            return redirect()->route('auth.login');
        }else if(90 <= Auth::user()->grade){
            return $next($request);
        }

        //권한없는 사용자인 경우
        return redirect('memo')->send();
    }
}
