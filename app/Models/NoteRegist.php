<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoteRegist extends Model
{
  use SoftDeletes;
  protected $guarded=[];
  public function getNoteTypeAttribute($attribute){
    return [
      0=>'브랜드기조',
      1=>'신규런칭아이템',
      2=>'Proposal map',
      3=>'Proposal entry',
      4=>'Project map',
      ][$attribute];
    }
  protected $casts = [
    'created_at' => 'date:Y-m-d',
    'updated_at' => 'date:Y-m-d',
  ];
  public function empmaster(){
    return $this->belongsTo(setting\EmpMaster::class, 'emp_id');
  }
  public function brand(){
    return $this->belongsTo(BrandMaster::class);
  }
  public function histories(){
    return $this->hasmany(NoteHistory::class);
  }

  public static function getbrand($pgm){
    /*
    쿼리빌더에서 제약을 걸 때 클로저 함수 사용.
    클로저 함수 내에서 외부 변수를 사용해야 할때 use($pgm ,$name, $part, ...)처럼 해줘야한다
    */
    $brands = NoteRegist::with(['brand'=> function ($query) use($pgm){
        $query->where([['use_yn', 0],['pgm_div',$pgm]]);
      }
    ])->groupBy('brand_id')->get('brand_id');
    return response()->json(array('brands' => $brands ));
  }
}
