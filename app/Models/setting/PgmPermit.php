<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Model;

class PgmPermit extends Model
{
    public $timestamps = false;
    protected $guarded  = [];

    // public static function getPermit($user_id){
    //   $get_permit = PgmPermit::where([['emp_id',$user_id],['permit',0]])->whereOr('permit','')->get('pgm_id')->toArray();
    // }

}
