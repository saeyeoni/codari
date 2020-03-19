
  document.addEventListener("DOMContentLoaded", function(){
    let url        = window.location.pathname;
    let marketing    = url.indexOf("marketing");
    let overseas   = url.indexOf("overseas");
    let setting = url.indexOf("setting");

    if( marketing != -1){
      document.querySelector("#marketing > a").classList.add("on");
    }
    if( overseas != -1){
      document.querySelector("#overseas > a").classList.add("on");
    }
    if( setting != -1){
      document.querySelector("#setting > a").classList.add("on");
    }


    // document.getElementById("urlText").innerHTML=url;

    // let sessionId = window.sessionStorage.getItem(login_id);
    // document.getElementById("urlText").innerHTML=sessionId;


  });
