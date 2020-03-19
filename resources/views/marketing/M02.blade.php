
<h5 class="page-head-line">
  {{ $pgm_info->m_pgm_nm  }} ({{$pgm_info->m_pgm_id}})
</h5>

  <div class="brands">
    <h5>고객사</h5>
    <ul id="brandlist" class="brandlist-t"></ul>
  </div>
  <H5 id="brand_nm">　</h5>

  <div class="tables" id="tables" onscroll="scrollFun()">
    <table class="table table-bordered info" id="info">
      <tr id="fd"></tr>
      <tr id="fw"></tr>
    </table>
    <table class="table table-bordered" style="width:max-content;"id="t0"></table>
  </div>




<script type="text/javascript">
window.addEventListener("DOMContentLoaded", function(){
  // genRowspan("bg");
  // genRowspan("u");
  getBrands();
  let scrollPosition = document.getElementById("tables").scrollY;
console.log(scrollPosition);
})
function getBrands(){
  $.ajax({
    type: "GET",
    url: "{{ route('brands')}}",
    data: {
      _process:"getbrands",
      _token : $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: "json",
    success: function(data) {
      let node="";
      for(i=0; i<data.brands.length; i++){
        // node2 = node2 + '<li onclick="liClick(this.id)"; id="'+data.brands[i].id+'"><a href="">'+data.brands[i].nm+'</a></li>';
        node = node + '<li class="li" onclick="liClick(this.id,this.textContent)"; id="'+data.brands[i].id+'">'+data.brands[i].nm+'</li>';

      }
      document.getElementById("brandlist").innerHTML = node;
    }
  });
}
function liClick(getBrand_id,getBrand_name){
  /*li선택시 active 효과주기 초기 active값이 없으므로 replace로 "active",""변환*/
  let liContainer = document.getElementById("brandlist");
  let lis = liContainer.getElementsByClassName("li");
  for (let i = 0; i < lis.length; i++) {
    lis[i].addEventListener("click", function() {
      let current = document.getElementsByClassName("active");
      if (current.length > 0) {
        current[0].className = current[0].className.replace(" active", "");
      }
      this.className += " active";
    });
  }
  document.querySelector("#brand_nm").innerHTML = getBrand_name;

  /*테이블 작성*/
  let brand_id = getBrand_id;
  $.ajax({
    type: "GET",
    url: "{{ route('list')}}",
    data: {
      _process: brand_id,
      _token : $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: "json",
    success: function(data) {
      console.log(data);
      /*
      열들의 정보를 나타내는 info테이블의 정보를 뿌리기
      */
      let date_info='<td class="first-date" id="first-date">최초생성일</td>';
      let write_info='<td id="first-write">최초작성자</td>';
      for(let i=0; i<data.info.length; i++){
          date_info = date_info + '<td class="first-date">'+data.info[i].created_at+'</td>';
          write_info = write_info + '<td >'+data.info[i].emp_nm+'</td>';
      }
      document.getElementById("fd").innerHTML = date_info;
      document.getElementById("fw").innerHTML = write_info;
      /*
      노트 내용 테이블 뿌리기
      */
      let pgm_id = '{{$pgm_info->m_pgm_id}}';
      let emp_id = '{{Session::get('login_id') }}';
      let note="";
      let con="";
       for(let i=0; i<data.a.length; i++){
         let note_id;
         /*DB에는 0,1,2,3...으로 note_type이 들어가있지만 NoteRegist 모델에서 note_type에 대해 Accessor를 만들어 해당 값들로 치환해 디비에서 꺼내온다*/
         switch(data.a[i].note_type){
           case "브랜드기조":
            note_id = "0";
           break;
           case "신규런칭아이템":
           note_id = "1";
           break;
           case "Proposal map":
           note_id = "2";
           break;
           case "Proposal entry":
           note_id = "3";
           break;
           case "Project map":
           note_id = "4";
           break;
         }
           note = note + '<tr><td class="note note'+note_id+'">'+data.a[i].note_type+'</td>';

           if(data.a[i].note_type == "Proposal map" || data.a[i].note_type == "Proposal entry"){
             note = note + '<td class="use use'+note_id+'" colspan="2">'+data.a[i].use_type+'</td>';

           }else if(data.a[i].note_type =="Project map"){
             note = note + '<td class="use use'+note_id+'" colspan="2">'+data.a[i].map_name+'</td>';
           }else{
              note = note + '<td class="use use'+note_id+'">'+data.a[i].use_type+'</td>';
              note = note +'<td class="prd prd'+note_id+'">'+data.a[i].prd_type+'</td>';
           }

           for(let j=0; j<=data.col_max; j++){
             if(data.a[i].column_index == j){
                  note = note + '<td class="cont col-i-'+j+'"><a href="javascript:popupWindow(\''+pgm_id+'/'+data.a[i].id+'\')">'+data.a[i].content+'</a></td>';
             }else{
               note = note + '<td class="cont "></td>';
             }
           }
           note= note + '</tr>';
       }

      document.getElementById("t0").innerHTML = note;
      genRowspan("note0");
      genRowspan("use0");
      genRowspan("prd0");

      genRowspan("note1");
      genRowspan("use1");
      genRowspan("prd1");

      genRowspan("note2");
      genRowspan("use2");
      genRowspan("prd2");

      genRowspan("note3");
      genRowspan("use3");
      genRowspan("prd3");
      genRowspan("note4");
      genRowspan("use4");
      genRowspan("prd4");


      }
  });
}
function genRowspan(className){
    $("." + className).each(function() {
        var rows = $("." + className + ":contains('" + $(this).text() + "')");
        if (rows.length > 1) {
            rows.eq(0).attr("rowspan", rows.length);
            rows.not(":eq(0)").remove();
        }
    });
}
function popupWindow(param){
  let setting_val=" width=800, height=700, toolbar=no, menubar=no, scrollbars=no, resizable=yes";
  let pop = window.open(param,"popup",setting_val);

}

function scrollFun(){
  let t = document.getElementById("tables");
  let xScroll = $(".tables").scrollLeft();
  let yScroll = $(".tables").scrollTop();
  console.log();
  $(".note").css({"left" : xScroll});
  $(".use").css({"left" : xScroll});
  $(".prd").css({"left" : xScroll});
  $("#first-date").css({"left" : xScroll});
  $("#first-write").css({"left" : xScroll});
  $(".info").css({"top" : yScroll});
}
</script>
