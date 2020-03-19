<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\sidebarTrait;

class MainController extends Controller
{
  use sidebarTrait;

  public function index(){
    $value = session('login_id');
    return view('main',['value'=>$value]);
  }

  public function destroy(){
    session()->forget(['login_id','login_grade','overseas_conn']);
    return redirect('/');
  }

  public function setSidebar($menu_id){
    $sidebar = $this->sidebar($menu_id)->all();
    // dd($sidebar);
    return view('sidebar', compact('sidebar') );
  }
}
