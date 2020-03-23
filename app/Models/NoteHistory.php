<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteHistory extends Model
{
  protected $guarded=[];
  protected $casts = [
    'created_at' => 'date:Y-m-d',
    'updated_at' => 'date:Y-m-d',
  ];
  public function noteRegist(){
    return $this->belongsTo(NoteRegist::class, 'note_id','id');
  }
  public function empmaster(){
    return $this->belongsTo(setting\EmpMaster::class, 'emp_id');
  }

}
