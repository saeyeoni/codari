<?php
namespace App\Http\Controllers\overseas;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\BrandMaster;
use App\Models\NoteRegist;
use App\Models\NoteHistory;
use App\Models\setting\PgmPermit;


function alertMasg($param){
  echo("<script>alert('".$param."');</script>");
}
function jsFunCall($param){
  return ("<script>".$param."</script>");
}
class O01Controller extends Controller
{
  public function index(){

  }
  public function create(){
    if(session()->has('error')){
      $masg = session()->get('error');
      alertMasg(".$masg.");
      return jsFunCall("close();");
    }
    $request = request();
    $login_id = session()->get('login_id');
    $popup_div = "save";
    $div = "overseas";
    return view('popup',compact('popup_div','div'));
  }

  public function store(){
    $request = request();
    $emp_id = session()->get('login_id'); //작성자
    $note_type = $request->note_type; //작성유형
    $PROC = $request->process;
    switch ($PROC) {
      case 'store':
      // 브랜드입력 구분, direct시 새로 추가되는 brand, 최초열 생성
      if($request->brand_id == 'direct'){
        BrandMaster::create([
          'nm' => $request->direct_brand,
          'pgm_div' => $request->pgm,
        ]);
        $brand_id = BrandMaster::where('nm',$request->direct_brand)->value('id');
      }else{
        $brand_id = $request->brand_id;
      }
      //가장 높은 수 = 마지막 열의 column_index select
      $f_col = NoteRegist::where([['brand_id',$brand_id],['pgm_div',$request->pgm]])
      ->orderBy('column_index', 'desc')
      ->first();

      /*
      note_type이 0,1이면
      use_type은 노상관
      prd_type이 direct면 현재 columd에 추가
      최초등록, f_col이 null일때는 첫번째 열생성 columnidex = 0, first_div=1.
      최초등록이 아니면 행에 추가 columnidex = 마지막열번호, first_div=0
      prd_type이 direct가 아니면 이미 존재하는 카테고리로 등록시
      새로운 열추가 columnindex + 1, first_div = 0

      note_type이2,3,4이면 열추가,생성의 기준은 use_type이 된다
      */

      if($note_type==0 || $note_type==1){
        $map_name = "";
        $request->use_type=="direct" ? $use_type = $request->direct_use_type : $use_type = $request->use_type;
        if($request->prd_type=="direct"){
          $f_col==null ? $column_index=0 : $column_index = $f_col->column_index;
          $f_col==null ? $first_div=1 : $first_div=0;
          $prd_type = $request->direct_prd_type;
        }else{
          $prd_type = $request->prd_type;
          $column_index = $f_col->column_index +1;
          $first_div = 1;
        }
      }
      if($note_type==2 || $note_type==3){
        $map_name = "";
        $prd_type = "";
        if($request->use_type=="direct"){
          $f_col==null ? $column_index=0 : $column_index = $f_col->column_index; //널이면 첫열 생성 아니면 현재 열에 추가
          $f_col==null ? $first_div=1 : $first_div=0;
          $use_type = $request->direct_use_type;
        }else{
          $column_index = $f_col->column_index +1; //직접입력이 아니면 열 생성
          $first_div = 1;
          $use_type = $request->use_type;
        }
      }
      if($note_type==4){
        $use_type = "";
        $prd_type = "";
        if($request->sel_pj=="direct"){
          $map_name = $request->direct_sel_pj;
          $f_col==null ? $column_index=0 : $column_index = $f_col->column_index; //널이면 첫열 생성 아니면 현재 열에 추가
          $f_col==null ? $first_div=1 : $first_div=0;
        }else{
          $map_name = $request->sel_pj;
          $column_index = $f_col->column_index +1; //직접입력이 아니면 열 생성
          $first_div = 1;
        }
      }
      if($use_type == "총평"){
        $prd_type = '';
        $column_index = $f_col->column_index;
        $first_div = 0;
            }
      break;
      case 'direct_store':
      $brand_id = $request->regist_brand_id;
      $brand_nm = $request->regist_brand_nm;
      $emp_id = session()->get('login_id');
      $note_type_nm = $request->regist_note_type;
      $map_name = '';
      $use_type = $request->regist_use_type;
      $prd_type = $request->regist_prd_type;
      switch($note_type_nm){
        case '브랜드기조':
        $note_type = '0';
        break;
        case '신규런칭아이템':
        $note_type = '1';
        break;
        case 'Proposal map':
        $note_type = '2';
        $prd_type = '';
        break;
        case 'Proposal entry':
        $note_type = '3';
        $prd_type = '';
        break;
        case 'Project map':
        $note_type = '4';
        $map_name=$request->regist_map_name;
        $use_type='';
        $prd_type='';
        break;
      }
      //가장 높은 수 = 마지막 열의 column_index select
      $f_col = NoteRegist::where([['brand_id',$brand_id],['pgm_div',$request->pgm]])
      ->orderBy('column_index', 'desc')
      ->first();
      $column_index = $f_col->column_index;
      $first_div = 0;
      if($use_type == "총평"){
        $prd_type = '';
        $column_index = $f_col->column_index;
        $first_div = 0;
        }
      break;
    }

    NoteRegist::create([
      'pgm_div' => $request->pgm,
      'brand_id' => $brand_id,
      'emp_id' => $emp_id,
      'note_type' => $note_type,
      'map_name' => $map_name,
      'use_type' => $use_type,
      'prd_type'=> $prd_type,
      'column_index' => $column_index,
      'first_div' => $first_div,
      'content' => $request->content,
    ]);
    $latestRow = NoteRegist::latest()->value('id');
    NoteHistory::create([
      'note_id' => $latestRow,
      'content' => $request->content,
      'emp_id' => $emp_id,
    ]);
    if($PROC == 'store'){
      alertMasg("저장되었습니다.");
      return jsFunCall("parent.clear();");
    }
    if($PROC == 'direct_store'){
      alertMasg("저장되었습니다.");
      return jsFunCall("window.opener.liClick('".$brand_id."','".$brand_nm."'); close();");
    }
  }

  public function getBrands(){
    $request = request();
    return NoteRegist::getbrand($request->pgm);
  }
  public function getItems(){
    $request = request();
    $brand_id = $request->brand_id;
    $ut_v = $request->ut_op_value;
    $v = $request->op_value;
    $t = $request->ut_op_text;
    $PROC = $request->_process;
    switch ($PROC) {
      case 'note_type':
      $map="";
      if($v == 4){
        $map = NoteRegist::where([['note_type','4'],['brand_id',$brand_id],['pgm_div',$request->pgm]])->groupBy('map_name')->get('map_name');
      }
      $result = NoteRegist::where([['note_type',$v],['brand_id',$brand_id],['pgm_div',$request->pgm]])->groupBy('use_type')->get('use_type');
      return response()->json(array('result' => $result , 'map'=>$map));
      break;
      case 'use_type':
      $result = NoteRegist::where([['note_type',$ut_v],['use_type',$t],['brand_id',$brand_id],['pgm_div',$request->pgm]])->groupBy('prd_type')->get('prd_type');
      return response()->json(array('result' => $result ));
      break;


      default:
      break;
    }
  }
}
