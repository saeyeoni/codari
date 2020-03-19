<?php
namespace App\Http\Controllers\overseas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BrandMaster;
use App\Models\NoteRegist;
use App\Models\NoteHistory;
use App\Models\setting\EmpMaster;

function alertMasg($param){
  echo("<script>alert('".$param."');</script>");
}
function jsFunCall($param){
  return ("<script>".$param."</script>");
}
class O02Controller extends Controller
{
  public function show(NoteRegist $id){
    $history_list = NoteHistory::where('note_id',$id->id)
    ->orderBy('id','desc')
    ->get();
    return view('popup',compact('id','history_list'));
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
    $request = request();
    $new_content = $request->content;
    NoteRegist::where('id',$id->id)
    ->update(['content'=>$new_content]);

    NoteHistory::create([
      'note_id' => $id->id,
      'content'=>$new_content,
    ]);
    alertMasg("수정되었습니다.");
    return jsFunCall("opener.liClick('".$brand_id."','".$brand_nm."'); close();");
  }


  public function getBrands(){
    $brands = BrandMaster::all();
    return response()->json(array('brands' => $brands ));
  }
  public function getList(){
    $request = request();
    $info = NoteRegist::select('note_regists.emp_id','emp_masters.emp_nm','note_regists.created_at')
    ->leftjoin('emp_masters', 'note_regists.emp_id','=','emp_masters.emp_nb')
    ->where([['note_regists.first_div','1'],['note_regists.brand_id',$request->_process],['note_regists.pgm_div','overseas']])
    ->get();
    $col_max =NoteRegist::where([['brand_id',$request->_process],['note_regists.pgm_div','overseas']])->max('column_index');
    $n = NoteRegist::max('note_type');
    // $num = $n->count();
    $a = array();
    for($i=0;$i<=$n;$i++){
      $v = NoteRegist::where([
        ['brand_id',$request->_process],
        ['note_type',$i],
        ['pgm_div','overseas']
        ])->orderBy('note_type')->orderBy('use_type')->orderBy('prd_type')->orderBy('created_at')->get()->toArray();
        array_push($a, ...$v);
      }

      return response()->json(array('col_max'=>$col_max,'n'=>$n,'a'=>$a,'info'=>$info));
    }

  }
