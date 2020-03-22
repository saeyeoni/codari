<?php

namespace App\Http\Controllers;

use App\Traits\ipCheckTrait;
use App\Models\setting\EmpMaster;
use App\Models\setting\PgmPermit;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
  use ipCheckTrait;
  public function login(){
    return view('login.login');
  }

  public function loginCheck(Request $request){

    $PROC = $request->PROC;
    switch($PROC){
      case "LOGIN":
      $user_id = $request->user_id;
      $user_pw = $request->user_pw;

      $checkQR = EmpMaster::where('emp_nb', $user_id)->first(); //object 네이밍시 서술, 단수형
      $checkQR2 = EmpMaster::where('emp_nb', $user_id);

      /*
      where 조건을 걸고 first() 또는 get() 메서드를 사용하면
      stdClass 객체를 반환하게 된다.
      stdClass로 반환된 객체는 객체->필드명 으로 가져오면 끝;

      즉 $checkQR 얘는 EmpMaster::where('emp_nb', $user_id)->first() 이 조건에 만족하는 결과를
      stdClass 형태로 생성하여 보유하고 있는 것 뿐, $checkQR 자체는 여전히 EmpMaster 전체라고 보면 됨.
       */
      $grade = $checkQR->login_grade;
      $conn = $checkQR->overseas_ny;
      if($checkQR == null){
        return response()->json(['LOGIN_ERROR']);
      }
      $login_pw = $checkQR->login_pw;
      if(!Hash::check($user_pw, $login_pw)){
        return response()->json(['LOGIN_ERROR']);
      }
      if($user_pw=='1111'){
        $resArr = $checkQR->toArray();
        array_push($resArr, "FIRST_LOGIN");
        return response()->json($resArr);
      }
      $get_nm = EmpMaster::where('emp_nb', $user_id)->value('emp_nm');
      $get_part = EmpMaster::where('emp_nb', $user_id)->value('part');
      $get_overYN = EmpMaster::where('emp_nb', $user_id)->value('overseas_ny');
      $country_code = $this->ipCheck();

      if($get_overYN == "불가능" && $country_code!="KR"){
        return response()->json(['CONN_ERROR']);
      }
      session(['login_id' => $user_id,
                'login_grade' => $grade,
                'overseas_conn' => $conn,
                'emp_nm' => $get_nm,
                'emp_part' => $get_part,
              ]);
      return response()->json(['SUCCESS']);
      break;

      case "NEW_PW":
      $new_pw = $request->new_pw;
      $user_id = $request->user_id;

      $updateQR =EmpMaster::where('emp_nb', $user_id)
                            ->update(['login_pw' => bcrypt($new_pw)]);
      return 'success';
      break;
    }
  }
}
