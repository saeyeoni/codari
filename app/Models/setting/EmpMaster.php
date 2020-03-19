<?php

namespace App\Models\setting;


use Illuminate\Database\Eloquent\Model;

class EmpMaster extends Model
{
  protected $primaryKey = 'emp_nb';
  protected $guarded=[];

  //접근자 만들기 get칼럼명Attribute 카멜케이스
  //모델에서 데이터를 가져올때 자동으로 속성을 변환하는 기능
  //Mutator 은 set칼럼명Attribute 모델에 데이터를 입력할 때 자동으로 속성값 설정
  public function getEmpDivAttribute($attribute){
    return [
      0=>'재직중',
      1=>'퇴사'
    ][$attribute];
  }

  public function getOverseasNyAttribute($attribute){
    return [
      0=>'불가능',
      1=>'가능'
    ][$attribute];
  }

}
