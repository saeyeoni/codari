<?php
namespace App\Http\Controllers\marketing;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\BrandMaster;
use App\Models\NoteRegist;
use App\Models\NoteHistory;
use App\Models\setting\EmpMaster;
use App\Models\setting\PgmPermit;

function alertMasg($param){
  echo("<script>alert('".$param."');</script>");
}
function jsFunCall($param){
  return ("<script>".$param."</script>");
}
class M02Controller extends Controller
{
  public function show(NoteRegist $id){
    $login_id = session()->get('login_id');
    $get_edit_permit =PgmPermit::where([['emp_id',$login_id],['edit_permit',1]])->get('pgm_id')->toArray();
    $edit_permit = Arr::flatten($get_edit_permit);
    $popup_div = "edit";
    $history_list = NoteHistory::where('note_id',$id->id)
    ->orderBy('id','desc')
    ->get();
    return view('popup',compact('id','history_list','edit_permit','popup_div'));
  }
  public function softDelete(NoteRegist $id){
    $brand_id = $id->brand_id;
    $brand_nm = $id->brand->nm;
    $first_div = $id->first_div;
    /*
    softDelete로 delete()시
    NoteRegist테이블의 delete_at필드가 null에서 해당시간으로 변경,
    실제 데이터가 사라지지않는다.
    단, first_div = 1 일때는 다음으로 생성된 로우에 first_div=1부여
    */
    if($first_div == 1){
      /*삭제할로우의 다음row아이디 select*/
      $getId = NoteRegist::where([['column_index',$id->column_index],['brand_id',$brand_id]])
      ->orderBy('id')
      ->limit(1)
      ->offset(1)
      ->value('id');
      $setDiv = NoteRegist::where('id', $getId)
      ->update( ['first_div'=>'1'], );
    }
    NoteRegist::where('id', $id->id)
    ->delete();
    alertMasg("삭제되었습니다.");
    return jsFunCall("opener.liClick(".$brand_id.",".$brand_nm.");close();");
  }
  public function update(NoteRegist $id){
    $brand_id = $id->brand_id;
    $brand_nm = $id->brand->nm;
    $emp_id = session()->get('login_id');
    $request = request();
    $new_content = $request->content;
    NoteRegist::where('id',$id->id)
    ->update(['content'=>$new_content]);

    NoteHistory::create([
      'note_id' => $id->id,
      'content'=>$new_content,
      'emp_id' => $emp_id,
    ]);
    alertMasg("수정되었습니다.");
    return jsFunCall("opener.liClick('".$brand_id."','".$brand_nm."'); close();");
  }


  public function getBrands(){
    $request = request();
    //NoteRegist모델의 getBrand()를 리턴
    return NoteRegist::getbrand($request->pgm);
  }


  public function delBrand($id){
    $request=request();
    $pgm = $request->pgm;
    $result = BrandMaster::where([['id',$id],['pgm_div',$pgm]])->update(['use_yn'=>1]);
    return $result;
  }


  public function getList(){
    $request = request();

    $info = NoteRegist::select('note_regists.emp_id','emp_masters.emp_nm','note_regists.created_at')
    ->leftjoin('emp_masters', 'note_regists.emp_id','=','emp_masters.emp_nb')
    ->where([['note_regists.first_div','1'],['note_regists.brand_id',$request->brand_id],['note_regists.pgm_div','marketing']])
    ->get();
    $col_max =NoteRegist::where([['brand_id',$request->brand_id],['note_regists.pgm_div','marketing']])->max('column_index');
    $n = NoteRegist::max('note_type');
    $p = array();
    $row = NoteRegist::where([['pgm_div','marketing'],['brand_id',$request->brand_id]])->orderBy('id')->get()->groupBy(['use_type','prd_type'])->count();

    $m = NoteRegist::where([['pgm_div','marketing'],['brand_id',$request->brand_id]])->orderBy('note_type','asc')->orderBy('id')->get()->groupBy(['note_type','use_type','prd_type'])->toArray();
    $project_map_list = NoteRegist::where([['pgm_div','marketing'],['note_type', '4'],['brand_id',$request->brand_id]])->orderBy('id')->get()->groupBy(['note_type','map_name','prd_type'])->toArray();



    $noterow = [];
    $userow = [];
      for($i=0;$i<=$n;$i++){
        if($i == '0' || $i=='1'){
          $v = NoteRegist::where([['pgm_div','marketing'],['note_type',$i],['brand_id',$request->brand_id]])->groupBy('prd_type')->get('prd_type')->count();
        }
        if($i == 2 || $i==3){
          $v = NoteRegist::where([['pgm_div','marketing'],['note_type',$i],['brand_id',$request->brand_id]])->groupBy('use_type')->get('use_type')->count();
        }
        if($i==4){
          $v = NoteRegist::where([['pgm_div','marketing'],['note_type',$i],['brand_id',$request->brand_id]])->groupBy('map_name')->get('map_name')->count();
        }
        array_push($noterow , $v);
      }

      return response()->json(array('col_max'=>$col_max,'info'=>$info,'m'=>$m,'row_num'=>$noterow, 'pml'=>$project_map_list));

    }
  }
