<?php
namespace App\Http\Controllers\marketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BrandMaster;
use App\Models\NoteRegist;
use App\Models\NoteHistory;

function alertMasg($param){
  echo("<script>alert('".$param."');</script>");
}
function jsFunCall($param){
  return ("<script>".$param."</script>");
}
class M01Controller extends Controller
{
  public function index(){

  }
  public function store(){
    $request = request();
    if($request->brand_id == 'direct'){
      BrandMaster::create([
        'nm' => $request->direct_brand,
      ]);
      $brand_id = BrandMaster::where('nm',$request->direct_brand)->value('id');
    }else{
      $brand_id = $request->brand_id;
    }
    //가장 높은 수의 column_index select
    $f_col = NoteRegist::where([['brand_id',$brand_id],['pgm_div',$request->pgm]])
                            ->orderBy('column_index', 'desc')
                            ->first();
    if($request->first_div){
      $first_div = $request->first_div; //새로운 열 추가 first_div=1
      if(!$f_col){    //쳣 열 생성, column_index=0
        $column_index= 0 ;
      }else{
        $column_index = $f_col->column_index+1; // 열번호 1씩 증가
      }
    }else{
      if(!$f_col){
        alertMasg("최초 등록시 새로운열에추가를 체크해주세요.");
        return jsFunCall("parent.clear();");
      }else{
        $first_div = 0; //새로운 열 추가가 아니면 first_div=0
        $column_index = $f_col->column_index;
      }
    }
    $emp_id = session()->get('login_id'); //작성자
    $note_type = $request->note_type; //작성유형
    //작성유형이 project_map(value=4)일때, 직접입력일때
    if($note_type==4){
      if($request->sel_pj =="direct"){
        $map_name = $request->direct_sel_pj;
      }else{
        $map_name = $request->sel_pj;
      }
    }else{
      $map_name = "";
    }
    if($request->use_type=="direct"){
      $use_type = $request->direct_use_type;
    }else{
      $use_type = $request->use_type;
    }
    if($request->prd_type=="direct"){
      $prd_type = $request->direct_prd_type;
    }else{
      $prd_type = $request->prd_type;
    }
    if($request->prd_type == null){
      $prd_type="　";
    }
    if($request->use_type == null){
      $use_type="　";
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
    ]);
    alertMasg($request->emp_nb."저장되었습니다.");
    return jsFunCall("parent.clear();");
  }

  public function getBrands(){
    $brands = BrandMaster::all();
    return response()->json(array('brands' => $brands ));
  }
  public function getItems(){
    $request = request();
    $ut_v = $request->ut_op_value;
    $v = $request->op_value;
    $t = $request->ut_op_text;
    $PROC = $request->_process;
    switch ($PROC) {
      case 'note_type':
        $map="";
        if($v == 4){
          $map = NoteRegist::where('note_type','4')->groupBy('map_name')->get('map_name');
        }
        $result = NoteRegist::where('note_type',$v)->groupBy('use_type')->get('use_type');
        return response()->json(array('result' => $result , 'map'=>$map));
        break;
      case 'use_type':
        $result = NoteRegist::where([['note_type',$ut_v],['use_type',$t]])->groupBy('prd_type')->get('prd_type');
        return response()->json(array('result' => $result ));
        break;


      default:
        break;
    }
  }
}
