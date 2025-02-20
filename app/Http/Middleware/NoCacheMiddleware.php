<?php

namespace App\Http\Middleware;

use Closure;

class NoCacheMiddleware
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
      $response = $next($request);

     // 웹페이지 캐시 비활성화 - 로그아웃후 뒤로가기시 로그인된 화면이 보이는 것 방지.
     if (method_exists($response, 'header')) {
         $response->header('Cache-Control', 'private, no-cache, no-store, must-revalidate');
         $response->header('Pragma', 'no-cache');
     }

     return $response;
    }
}
