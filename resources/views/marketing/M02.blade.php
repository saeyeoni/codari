
<h5 class="page-head-line">
  {{ $pgm_info->m_pgm_nm  }} ({{$pgm_info->m_pgm_id}})
  <button type="button" id="btn-regist" name="button" class="btn btn-sm btn-primary" onclick="location.href='/marketing/M01'"><i class="fas fa-file"></i> 노트등록</button>

</h5>

<div class="brands">
  <h5>고객사</h5>
  <div class="brands_">
    <ul id="brandlist" class="brandlist-t"></ul>
  </div>
</div>

<H5 id="brand_nm">　</h5>
  <div class="tables" id="tables" onscroll="scrollFun()">
    <table class="table table-bordered info" id="info">
      <tr id="fd"></tr>
      <tr id="fw"></tr>
    </table>
    <table class="table table-bordered" style="width:max-content;"id="t0"></table>

  </div>

  <form name="passform" target="popup">
    <input type="hidden" name="regist_brand_nm">
    <input type="hidden" name="regist_note_type">
    <input type="hidden" name="regist_use_type">
    <input type="hidden" name="regist_prd_type">
    <input type="hidden" name="regist_map_name">

  </form>

  <script type="text/javascript">
  window.addEventListener("DOMContentLoaded", function(){
    getBrands();
    let scrollPosition = document.getElementById("tables").scrollY;
  })
  function getBrands(){
    $.ajax({
      type: "GET",
      url: "{{ route('brands')}}",
      data: {
        pgm:"marketing",
        _process:"getbrands",
        _token : $('meta[name="csrf-token"]').attr('content'),
      },
      dataType: "json",
      success: function(data) {
        let node="";
        for(i=0; i<data.brands.length; i++){
          if(data.brands[i].brand != null){
            node = node + '<span>';
            @if(Session::get('login_grade') == 1 )
            node = node + '<i class="fas fa-trash-alt" onclick="javascript:brandDelete(\''+data.brands[i].brand.id+'\',\''+data.brands[i].brand.nm+'\');"></i>';
            @endif
            node = node + '<li class="li" onclick="liClick(this.id,this.textContent)"; id="'+data.brands[i].brand.id+'">'
            +data.brands[i].brand.nm+'</li></span>';
          }
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
          current[0].className = current[0].className.replace("active", "");
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
        brand_id,
        _process: 'list',
        _token : $('meta[name="csrf-token"]').attr('content'),
      },
      dataType: "json",
      success: function(data) {
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
        for(let n=0; n<Object.keys(data.m).length; n++){  //Object.keys 키값으로 배열로 접근해 length반환
          switch(Object.keys(data.m)[n]){
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
          let nt = Object.keys(data.m)[n];  //data.m오브젝트중 n번째의 키값을 text로 가져온다
          let use_max = Object.keys(data.m[nt]).length; //use타입을 그리는for문의 조건값
          if(note_id != "4"){
            note = note + '<tr><td class="note note'+note_id+'" rowspan="'+data.row_num[note_id]+'">'+Object.keys(data.m)[n]+'</td>';
          }else{
            let nt = Object.keys(data.pml)[0];  //data.m오브젝트중 n번째의 키값을 text로 가져온다
            note = note + '<tr><td class="note note'+note_id+'" rowspan="'+data.row_num[note_id]+'">'+nt+'</td>';
            use_max = Object.keys(data.pml['Project map']).length;
          }

          for(let u=0; u<use_max; u++){
            let ut,prd_max,pt;

            if( note_id == "4"){
              ut = Object.keys(data.pml[nt])[u];
              prd_max = Object.keys(data.pml[nt][ut]).length;
              note = note + '<td class="subt subt'+note_id+'" colspan="2">'+ut+'</td>';
            }else if(note_id == "2" || note_id == "3"){
              ut = Object.keys(data.m[nt])[u];
              prd_max = Object.keys(data.m[nt][ut]).length;
              note = note + '<td class="subt subt'+note_id+'" colspan="2">'+ut+'</td>';
            }else{
              ut = Object.keys(data.m[nt])[u];
              prd_max = Object.keys(data.m[nt][ut]).length;
              note = note + '<td class="use use'+note_id+'" rowspan="'+Object.keys(data.m[nt][ut]).length+'">'+ut+'</td>';
            }

            for(let p=0; p<prd_max; p++){
              if( note_id == "4"){
                pt = Object.keys(data.pml[nt][ut])[p];
                note = note + '';
              }
              else if(note_id == "2" || note_id == "3"){
                pt = Object.keys(data.m[nt][ut])[p];
                note = note + '';
              }else{
                pt = Object.keys(data.m[nt][ut])[p];
                note = note + '<td class="prd prd'+note_id+'">'+Object.keys(data.m[nt][ut])[p]+'</td>';
              }

              let idx = 0 ;
              for(let c=0; c<=data.col_max; c++){
                let data_idx;
                if( note_id =="4"){
                  data_idx = data.pml[nt][ut][pt];
                }else{
                  data_idx = data.m[nt][ut][pt];
                }
                if(data_idx[idx] != null && data_idx[idx].column_index == c){
                  note = note + '<td class="cont col-i-'+c+'"><a href="javascript:popupWindow(\''+pgm_id+'/'+data_idx[idx].id+'\',\'edit\')">'+data_idx[idx].content+'</a></td>';
                  idx++;
                }else if(data.col_max == c){
                  let id = data_idx[0];
                  note = note + '<td class="regist"><a href="javascript:popupWindow(\'M01/create\',\'store\',\''+id.brand_id+'\',\''+id.note_type+'\',\''+id.use_type+'\',\''+id.prd_type+'\',\''+id.map_name+'\')">등록</a></td>';
                }else{
                  note = note + '<td class="nonetd"></td>';
                }
              }
              note = note + '</tr><tr>';
            }
          }

        }
        note = note.substring(-4,note.length);
        document.getElementById("t0").innerHTML = note;
        scrollFun();
      }
    });

  }
  function popupWindow(param,state,brand_nm,note_type,use_type,prd_type,map_name){
    let setting_val=" width=800, height=700, toolbar=no, menubar=no, scrollbars=no, resizable=yes";
    if(state == 'edit'){
      let pop = window.open(param,"popup",setting_val);
    }
    if(state == 'store'){
      document.querySelector("input[name='regist_brand_nm']").value = brand_nm;
      document.querySelector("input[name='regist_use_type']").value = use_type;
      document.querySelector("input[name='regist_note_type']").value = note_type;
      document.querySelector("input[name='regist_prd_type']").value = prd_type;
      // document.querySelector("input[name='regist_map_name']").value = map_name;
      //값이 있는지 없는지 판별
      let pop = window.open(param,"popup",setting_val);
    }
  }
  function brandDelete(paramId, paramNm){
    let answer = confirm(paramNm+"을(를) 목록에서 삭제하시겠습니까?");
    if(answer){
      $.ajax({
        type: "PATCH",
        url : "/marketing/M02/brands/"+paramId+"",
        data: {
          pgm:"marketing",
          _process:"delBrand",
          _token : $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: "text",
        success: function(data) {
          if(data==true){
            alert("삭제되었습니다.");
            clear();
          }else{
            alert("삭제하는데 문제가 발생하였습니다.");
          }
        },
        error: function(data) {
          alert("시스템ERROR, 관리자에게 문의하세요");
        }
      });

    }
  }
  function scrollFun(){
    let t = document.getElementById("tables");
    let xScroll = $(".tables").scrollLeft();
    let yScroll = $(".tables").scrollTop();
    $(".note").css({"left" : xScroll});
    $(".use").css({"left" : xScroll});
    $(".subt").css({"left" : xScroll});
    $(".prd").css({"left" : xScroll});
    $("#first-date").css({"left" : xScroll});
    $("#first-write").css({"left" : xScroll});
    $(".info").css({"top" : yScroll});
  }
  function clear(){
    location.reload();
  }
</script>
