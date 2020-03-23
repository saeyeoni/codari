
  document.addEventListener("DOMContentLoaded", function(){
    let url        = window.location.pathname;
    let marketing  = url.indexOf("marketing");
    let overseas   = url.indexOf("overseas");
    let setting = url.indexOf("setting");
    let m01  = url.indexOf("M01");
    let m02  = url.indexOf("M02");
    let o01  = url.indexOf("O01");
    let o02  = url.indexOf("O02");
    let st01  = url.indexOf("ST01");




    if( marketing != -1){
      document.querySelector("#marketing > a").classList.add("on");
    }
    if( overseas != -1){
      document.querySelector("#overseas > a").classList.add("on");
    }
    if( setting != -1){
      document.querySelector("#setting > a").classList.add("on");
    }
    if( m01 != -1){
      document.querySelector("#M01").classList.add("sidebar-on");
    }
    if( m02 != -1){
      document.querySelector("#M02").classList.add("sidebar-on");
    }
    if( o01 != -1){
      document.querySelector("#O01").classList.add("sidebar-on");
    }
    if( o02 != -1){
      document.querySelector("#O02").classList.add("sidebar-on");
    }
    if( st01 != -1){
      document.querySelector("#ST01").classList.add("sidebar-on");
    }



    // document.getElementById("urlText").innerHTML=url;

    // let sessionId = window.sessionStorage.getItem(login_id);
    // document.getElementById("urlText").innerHTML=sessionId;


  });
