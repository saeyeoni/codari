<!DOCTYPE html>
<html lang="ko" dir="ltr">

  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>COCO업무노트</title>

  {{-- <link rel="stylesheet" href="/css/app.css"> --}}
  {{-- <script type="text/javascript" scr="/js/jquery-3.2.1.min.js"></script> --}}


  <link rel="stylesheet" href="/css/font-awesome.min.css">
  <link rel="stylesheet" href="/css/basic.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/meanmenu.min.css">
  <link rel="stylesheet" href="/css/metisMenu/metisMenu.min.css">
  <link rel="stylesheet" href="/css/metisMenu/metisMenu-vertical.css" />
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/responsive.css">
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/jqx.base.css">
  <link rel="stylesheet" href="/css/items.css">
  <script type="text/javascript" src="/js/app.js"></script>
  <script type="text/javascript" src="/js/jqx-all.js"></script>
  <script type="text/javascript" src="/js/validation.js"></script>



  <style>

    </style>
  </head>
  <body>

    {{-- <div class="left-sidebar-pro">
      <nav id="sidebar" class="">
        <div class="sidebar-header">
          <a href="/main"><img class="main-logo" src="/images/logo_new.png" alt="" /></a>
          <strong><a href="/main"><img src="/images/logosn.png" alt="" /></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
          <nav class="sidebar-nav left-sidebar-menu-pro">
            <ul class="metismenu" id="menu1">
              @yield('sidebar_menu')
            </ul>
          </nav>
        </div>
      </nav>
    </div> --}}

    {{-- <div class="container-fluid reset-pd">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="logo-pro" style="height:50px;">
            <a href="menu"><img class="main-logo" src="/images/logosn.png"alt="" /></a>
          </div>
        </div>
      </div>
    </div> --}}
    <div class="header-advance-area">
      <div class="header-top-area header-size">
        <div class="container-fluid">
              <div class="header-top-wraper">

                  <div class="row">
                    <div class="logobox">
                      <a href="/main"><img class="main-logo" src="/images/logo_new.png" alt="" /></a>
                      {{-- <strong><a href="/main"><img src="/images/logosn.png" alt="" /></a></strong> --}}
                    </div>
                  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <div class="header-top-menu">
                      <ul class="nav nav-top">
                        <li id="marketing" class="nav-item btn-blueset"><a href="/marketing/M02" class="nav-link">마케팅</a></li>
                        <li id="overseas" class="nav-item btn-blueset"><a href="/overseas/O02" class="nav-link">해외영업</a></li>
                        @if (Session::get('login_grade')==1)
                          <li id="setting" class="nav-item btn-blueset"><a href="/setting/ST01" class="nav-link">설정</a></li>
                        @endif
                      </ul>
                    </div>
                  </div>

                  <a href="/logout" class="btn btn-danger btn-sm logout-btn"><i class="fas fa-sign-out-alt">Logout</i></a>

                </div>
              </div>
            </div>
          </div>
        </div>
    <div class="all-content-wrapper">
      <div id="content">
        @yield('content')
      </div>
    </div>
  </body>
  <script type="text/javascript">
  @if (session('error'))
        alert('{{ session('error') }}');
        console.log('error');
  @endif
  </script>
  <script type="text/javascript" src="/js/activeMenu.js"></script>
  <script type="text/javascript" src="/js/wow.min.js"></script>
  <script type="text/javascript" src="/js/jquery.meanmenu.js"></script>
  <script type="text/javascript" src="/js/jquery.sticky.js"></script>
  <script type="text/javascript" src="/js/metisMenu/metisMenu.min.js"></script>
  <script type="text/javascript" src="/js/metisMenu/metisMenu-active.js"></script>
  <script type="text/javascript" src="/js/main.js"></script>
  </html>
