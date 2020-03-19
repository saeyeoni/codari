<?php

namespace App\Traits;
use App\Models\setting\PgmMaster;
use App\Models\setting\PgmPermit;

trait sidebarTrait {
  public function sidebar($pgm_div){
    $login_id = session()->get('login_id');
    return PgmMaster::from('pgm_masters AS A')
    ->join('pgm_permits AS B', 'A.m_pgm_id','B.pgm_id')
    ->where([
        ['A.pgm_div',$pgm_div],
        ['B.emp_id',$login_id],
        ['B.permit',1],
        ])
        ->orderBy('A.sort_num')
        ->get();

  }
}
