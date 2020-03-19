<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class CheckSession
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
      //session이 login_id라는 key를 갖고있으면 요청을 실행 아니면 redirect(login)
      if($request->path() == '/' || $request->path() == 'login'){
        if(session()->has('login_id')){
          return redirect('main');
        }else{

          return $next($request);
        }
      }else{
        if(session()->has('login_id')){
          $permit_list = session()->get('pgm_permit');
          $check_permit = Str::contains($request->path(), $permit_list);
          if($check_permit == false){
            return $next($request);
          }else{
            session()->flash('error','접근권한이 없습니다. 관리자에게 문의해주세요');
            return redirect('main');
          }
        }else{
          return redirect('/')->with('status','로그인 후 이용해 주세요.');
        }
      }
    }
}
