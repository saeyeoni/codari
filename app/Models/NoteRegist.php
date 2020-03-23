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
    'created_at' => 'datetime:Y-m-d',
    'updated_at' => 'datetime:Y-m-d',
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
    $brands = NoteRegist::with(['brand'=> function ($query) use($pgm){
        $query->where([['use_yn', 0],['pgm_div',$pgm]]);
      }
    ])->groupBy('brand_id')->get('brand_id');
    return response()->json(array('brands' => $brands ));
    dd($brand);
  }
}
