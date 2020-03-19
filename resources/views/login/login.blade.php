<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>COCO업무노트</title>
  <link rel="stylesheet" href="css/app.css">
  <script type="text/javascript" src="js/app.js"></script>
  <style type="text/css">
  .login-block{

    /* background: linear-gradient(to bottom, #A5CC82, #00467F);  nerp*/
    /* background: linear-gradient(to right, #fa709a 0%, #fee140 100%); */
    background: linear-gradient(60deg, #64b3f4 0%, #c2e59c 100%); /*tasknote*/
    width:100%;
    padding : 10% 0 0 0;
    height: 100%;
  }
  .banner-sec{background-size:cover; border-radius: 0 10px 10px 0; padding:0;}
  .container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.3);}
  .carousel-inner{border-radius:0 10px 10px 0;}
  .carousel-caption{text-align:left; left:5%;}
  .login-sec{padding: 50px 30px; position:relative;}
  .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
  .login-sec .copy-text i{color:#8aecfe;}
  .login-sec .copy-text a{color:#62b8e3;}
  .login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #4c88d7;}
  .login-sec h2:after{content:" "; width:150px; height:5px; background:#8aecfe; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
  .banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
  .banner-text h2{color:#fff; font-weight:600;}
  .banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
  .banner-text p{color:#fff;}
  .carousel-item{
    height: 420px;
    width: auto;
  }
  /* .d-block{height: 100%; width: 100%;} */
  html, body {
    height:100%;
  }
  </style>
  <script type="text/javascript">
  @if (session('status'))
        alert('{{ session('status') }}')
  @endif
  </script>
</head>
<body>
<section class="login-block">
  <div class="container">
<div class="row">
  <div class="col-md-4 login-sec">
      <h2 class="text-center">Task NOTE</h2>
      <form id="login_form" method="post" autocomplete="off">

@csrf
<div class="form-group">
  <label class="text-uppercase">User ID</label>
                  <input type="text" name="user_id" class="form-control">
</div>
<div class="form-group">
  <label class="text-uppercase">Password</label>
          <input type="password" name="user_pw" class="form-control" onkeydown="if(event.keyCode==13) {login_check();}">
</div>
<br />
        <input type="button" value="Login" class="btn btn-primary btn-block" onclick="login_check()">

  </form>
  </div>
  <div class="col-md-8 banner-sec">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
          <div class="carousel-inner" role="listbox">
  <div class="carousel-item active">
    <img class="d-block img-fluid" src="/images/main_1.jpg" alt="First slide">
    <div class="carousel-caption d-none d-md-block">
      <div class="banner-text">
          <h2>COCO Cosmetics</h2>
          <p>신뢰를 바탕으로 고객의 만족을 위해 최선을 다하는 기업</p>
      </div>
</div>
  </div>
  <div class="carousel-item">
    <img class="d-block img-fluid" src="/images/main_2.jpg" alt="First slide">
    <div class="carousel-caption d-none d-md-block">
      <div class="banner-text">
        <h2>COCO Cosmetics</h2>
        <p>신뢰를 바탕으로 고객의 만족을 위해 최선을 다하는 기업</p>
      </div>
  </div>
  </div>
  <div class="carousel-item">
    <img class="d-block img-fluid" src="/images/main_3.jpg" alt="First slide">
    <div class="carousel-caption d-none d-md-block">
      <div class="banner-text">
        <h2>COCO Cosmetics</h2>
        <p>신뢰를 바탕으로 고객의 만족을 위해 최선을 다하는 기업</p>
      </div>
  </div>
</div>
          </div>

  </div>
</div>
</div>
</div>
</section>
  <div class="modal fade" id="login_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <span class="modal-title" id="login_id" style="font-size:25px;"></span>
          <span class="modal-title" style="font-size:25px;">:</span>
          <span class="modal-title" id="login_nm" style="font-size:25px;"></span>
          <button type="button" class="close" data-dismiss="modal" id="inout_button">&times;</button>

        </div>
        <div class="modal-body" id="login_modal_body">
          <div class="form-group">
            <label class="text-uppercase">패스워드</label>
            <input type="password" class="form-control" name="new_pw" placeholder="6자리이상">
          </div>
          <div class="form-group">
            <label class="text-uppercase">패스워드 확인</label>
            <input type="password" class="form-control" name="new_pw_cf" placeholder="" onkeydown="if(event.keyCode==13) {login_update();}">
          </div>
          <input type="button" class="btn btn-primary btn-block" value="확인" onclick="login_update()">
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript">

function login_check(){
  let user_id = document.querySelector("input[name=user_id]").value;
  let user_pw = document.querySelector("input[name=user_pw]").value;
  if(user_id==""){
    alert("아이디가 입력되지 않았습니다.");
    document.querySelector("input[name=user_id]").focus();
    return;
  }
  if(user_pw==""){
    alert("패스워드가 입력되지 않았습니다.");
    document.querySelector("input[name=user_pw]").focus();
    return;
  }
  $.ajax({
    method: "POST",
    url: "{{ route('loginCheck') }}",
    data: {
      user_id,
      user_pw,
      PROC: "LOGIN",
      _token : $('meta[name="csrf-token"]').attr('content')
    },
    dataType: "json",
    success: function(data){
      if(data[0] == "FIRST_LOGIN"){
        alert("처음 로그인하셨다면 패스워드를 변경해야합니다");
        document.querySelector("#login_id").innerText = data.emp_nb;
        document.querySelector("#login_nm").innerText = data.emp_nm;

        $("#login_modal").modal('show');
      }else if(data=="LOGIN_ERROR"){
        alert("로그인에 실패하였습니다.\n아이디와 패스워드를 확인해주세요.");
        inputclear();

      }else if(data=="SYSTEM_ERROR"){
        alert("System Error! 관리자에게 문의하세요.");
      }else if(data == "CONN_ERROR"){
        alert("해외에서 접속할 수 없습니다. 관리자에게 문의하세요.");
      }
      else{
        location.href = "/main";
      }
    }
  });
}
function login_update(){
  var new_pw    = document.querySelector("input[name=new_pw]").value;
  var new_pw_cf = document.querySelector("input[name=new_pw_cf]").value;
  var user_id = document.querySelector("input[name=user_id]").value;

  if(new_pw.length < 6 || new_pw_cf.length < 6){
    alert("패스워드는 6자리 이상으로 입력해주세요.");
    return;
  }
  if(new_pw != new_pw_cf){
    alert("입력한 패스워드가 일치하지 않습니다. 다시 시도해주세요.");
    return;
  }
  $.ajax({
    type: "POST",
    url: "{{route('loginCheck')}}",
    data: {
      new_pw,
      user_id,
      PROC: "NEW_PW",
      _token : $('meta[name="csrf-token"]').attr('content')
    },
    dataType: "json",
    success: function(data) {
      if(data=="SUCCESS"){
        alert("비밀번호 설정이 완료되었습니다. 다시 로그인 해주세요.");
        location.reload();
      }
    }
  });
}
function inputclear(){
  document.querySelector("input[name=user_id]").value = "";
  document.querySelector("input[name=user_pw]").value = "";
  document.querySelector("input[name=user_id]").focus();
}
</script>
</html>
