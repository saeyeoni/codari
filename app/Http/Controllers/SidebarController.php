<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\sidebarTrait;
use Illuminate\Support\Facades\Session;



class SidebarController extends Controller
{
  use sidebarTrait;
  public function index($menu_id,$pgm_id){
  $sidebar = $this->sidebar($menu_id)->all();
  $pgm_info = $this->sidebar($menu_id)->where('m_pgm_id',$pgm_id)->first();
  $request = Request();

  if($request->_process){
    $src = $menu_id.'\\'.$pgm_id.'Controller@index';
    return \App::call("App\Http\Controllers\\".$src,['pgm_info'=>$pgm_info]);
  }else{
    return view('sidebar')->with('sidebar', $sidebar)
                         ->with('pgm_info',$pgm_info);
                       }
  // return \App::call('App\Http\Controllers\setting\ST01Controller@index',['pgm_info'=>$pgm_info,'sidebar'=>$sidebar]);
  // return redirect()->action('setting\ST01Controller@index')->with('pgm_info',$pgm_info)
  //                  ->with('sidebar', $sidebar)
  //                  ->with('pgm_info',$pgm_info);

}
public function store($menu_id,$pgm_id){
  $src = $menu_id.'\\'.$pgm_id.'Controller@store';
  return \App::call("App\Http\Controllers\\".$src);
}
public function update($menu_id,$pgm_id){
  $src = $menu_id.'\\'.$pgm_id.'Controller@update';
  return \App::call("App\Http\Controllers\\".$src);
}
public function delete($menu_id,$pgm_id){
  $src = $menu_id.'\\'.$pgm_id.'Controller@delete';
  return \App::call("App\Http\Controllers\\".$src);
}
public function show($menu_id,$pgm_id,$id){
  $src = $menu_id.'\\'.$pgm_id.'Controller@show';
  return \App::call("App\Http\Controllers\\".$src,['id'=>$id]);
}


}
