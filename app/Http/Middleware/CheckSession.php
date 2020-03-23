<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\setting\PgmPermit;


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
          $login_id = session()->get('login_id');
          $get_permit = PgmPermit::where([['emp_id',$login_id],['permit',0]])->whereOr('permit','')->get('pgm_id')->toArray();
          $permit = Arr::flatten($get_permit);
          $check_permit = Str::contains($request->path(), $permit);
          if($check_permit == false){
            return $next($request);
          }else{
            $check_permit = Str::contains($request->path(), 'create');
            session()->flash('error','접근권한이 없습니다. 관리자에게 문의해주세요');
            if($check_permit == true){
              return $next($request);
            }
            return redirect('main');
          }
        }else{
          return redirect('/')->with('status','로그인 후 이용해 주세요.');
        }
      }
    }
}
