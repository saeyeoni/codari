<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
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
</head>
<body>
  @if($popup_div == 'edit')
    @if($id->pgm_div == 'marketing')
      @include('marketing.M01')
    @elseif($id->pgm_div == 'overseas')
      @include('overseas.O01')
    @endif
  @elseif($popup_div == 'save')
    @if($div == 'marketing')
      @include('marketing.M01')
    @elseif($div =='overseas' )
      @include('overseas.O01')
    @endif
  @endif

</body>
</html>
