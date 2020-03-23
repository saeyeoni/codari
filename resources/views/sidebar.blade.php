{{-- layout형성 main.blade.php상속 --}}
@extends('main')
{{--
yield:select = 부모:자식
main.blade.php의 @yield부분
--}}
@section('sidebar_menu')
 @foreach ($sidebar as $master)
   <li>
     <a class="has-arrow" href="{{$master->pgm_src}}">
       <i class="fas {{$master->m_pgm_icon}}"></i>
       <span class="mini-click-non" id="{{$master->m_pgm_id}}"> {{$master->m_pgm_nm}} ({{$master->m_pgm_id}})</span>
     </a>
   </li>
@endforeach
@endsection


@section('content')
  @isset($pgm_info)
    @include($pgm_info->pgm_src)
@endisset
@endsection
