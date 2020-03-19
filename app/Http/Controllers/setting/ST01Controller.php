<?php

namespace App\Http\Controllers\setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\setting\EmpMaster;
use App\Models\setting\PgmMaster;
use App\Models\setting\PgmPermit;



function jsFunCall($param){
  return ("<script>".$param."</script>");
}
function alertMasg($param){
  echo("<script>alert('".$param."');</script>");
}
class ST01Controller extends Controller
{

  public function index(){
    $request = Request();
    $PROC = $request->_process;
    switch ($PROC) {
      case 'search':
      $emps = EmpMaster::all();
      if($request->ajax()){
        return response()->json($emps);
      }
      break;
      case 'search2':
      $emp_nb =$request->emp_nb2;
      $pgms = PgmMaster::all();

      if(!$emp_nb){
        return response()->json();
      }


      $firQR = DB::table('pgm_masters')
      ->selectRaw("m_pgm_id as pgm_id, '' emp_id, '' permit, m_pgm_nm")
      ->get();

      $secQR = DB::table('pgm_permits')
      ->select('pgm_permits.pgm_id','pgm_permits.emp_id','pgm_permits.permit','pgm_masters.m_pgm_nm')
      ->leftJoin('pgm_masters', 'pgm_id', '=' , 'pgm_masters.m_pgm_id')
      ->where('pgm_permits.emp_id' ,$emp_nb)
      ->get();
      $resultQR = $secQR->union($firQR);

      /*서브쿼리를 사용하기 위해 작성, toSql()로 쿼리를 확인하니 $emp_nb 값이 ?되었다
      collection union()와 쿼리빌더 union은 다르다
      퀴리문은 공부가 필요 -2020.02.21*/
      // $resultQR = DB::query()->fromSub($firQR, 'K')
      // ->groupBy('pgm_id')
      // ->where('K.epm_id' , $emp_nb)
      // ->toSql();
      // ->get();


      if($request->ajax()){
        return response()->json($resultQR);
      }
      break;
    }

  }
  public function store(){
    $request = Request();
    $PROC = $request->_process;
    switch ($PROC) {
      case 'store':
      $checkQR = EmpMaster::where('emp_nb',$request->emp_nb)->count();
      if($checkQR == 0){
        EmpMaster::create([
          'emp_nb' => $request->emp_nb,
          'emp_nm' => $request->emp_nm,
          'part' => $request->part,
          'position' => $request->position,
          'emp_div' => $request->work,
          'overseas_ny'=> $request->conn
        ]);
        return response()->json(['SUCCESS']);
      }else{
        return response()->json(['ERROR']);
      }
      break;
      case 'store2':
      $re_json = $request->gridPgm;
      $emp_nb = $request->emp_nb2;
      $array = json_decode($re_json);
      $checkEmp = PgmPermit::where('emp_id',$emp_nb)->count();
      if($checkEmp != 0){
        return response()->json('error');
        break;
      }
      foreach($array as $col){
        PgmPermit::create([
          'pgm_id'=>$col->pgm_id,
          'emp_id'=>$emp_nb,
          'permit'=>$col->permit,
        ]);
      }
      return response()->json('success');
      break;
    }


  }


  public function update(){
    $request = Request();
    $PROC = $request->_process;
    switch ($PROC) {
      case 'update':
      $checkQR = EmpMaster::where('emp_nb',$request->emp_nb)->count();
      $result = '';
      if($checkQR == 1){
        EmpMaster::where('emp_nb',$request->emp_nb)
        ->update([
          'emp_nm' => $request->emp_nm,
          'part' => $request->part,
          'position' => $request->position,
          'emp_div' => $request->work,
          'overseas_ny'=> $request->conn
        ]);
        alertMasg($request->emp_nb."님의 정보를 수정했습니다.");
        return jsFunCall("parent.search();");
      }else{
        alertMasg($request->emp_nb."와 일치하는 정보가 없습니다. 입력하신 정보를 다시 확인해주세요.");
        return jsFunCall("parent.search();");
      }
      break;
      case 'update2' :
      $re_json = $request->gridPgm;
      $emp_nb = $request->emp_nb2;
      $array = json_decode($re_json);
      $checkEmp = PgmPermit::where('emp_id',$emp_nb)->count();
      if($checkEmp == 0){
        return response()->json('error');
        break;
      }
      foreach($array as $col){
        PgmPermit::where([['emp_id',$emp_nb], ['pgm_id',$col->pgm_id]])
        ->update([
          'pgm_id'=>$col->pgm_id,
          'permit'=>$col->permit,
        ]);
      }
      return response()->json('success');
      break;

    }

  }
}
