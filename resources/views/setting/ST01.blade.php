
<style type="text/css">
#gridEmp,
#gridPgm {
  height: 550px;
  overflow: hidden;
  border: 1px solid black;
}
input[type='radio']{
  margin-left: 10px;
}
</style>
<form name="main_form" method="post" autocomplete="off" enctype="multipart/form-data" >
  @csrf
  <input type="hidden" name="_method" value="">
  <h5 class="page-head-line">
    {{ $pgm_info->m_pgm_nm  }} ({{$pgm_info->m_pgm_id}})
  </h5>
  <div class="row">
    <div class="col-md-6 form-inline">
      <h5>사용자 관리</h5>
    </div>
    <div class="col-md-6 form-inline">
      <h5>프로그램권한</h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 form-inline">
      <div class="col-md-12 reset-pd form-inline">
        <div class="col-md-4 reset-pd input-group input-group-sm">
          <div class="input-group-prepend"><span class="input-group-text">사번(ID)</span></div>
          <input type="text" name="emp_nb" class="form-control">
        </div>
        <div class="col-md-4 reset-pd input-group input-group-sm">
          <div class="input-group-prepend"><span class="input-group-text">이름</span></div>
          <input type="text" name="emp_nm" class="form-control">
        </div>
        <div class="col-md-4 reset-pd input-group input-group-sm">
          <div class="input-group-prepend"><span class="input-group-text">부서</span></div>
          <input type="text" name="part" class="form-control">
        </div>
      </div>
    </div>
    <div class="col-md-6 form-inline">
      <div class="col-md-12 reset-pd  input-group input-group-sm">
        <div class="input-group-prepend"><span class="input-group-text">사번(ID)</span></div>
        <input type="text" name="emp_nb2" class="form-control" readonly="readonly">
        <div class="input-group-prepend"><span class="input-group-text">이름</span></div>
        <input type="text" name="emp_nm2" class="form-control" readonly="readonly">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 form-inline">
      <div class="col-md-12 reset-pd form-inline">
        <div class="col-md-4 reset-pd input-group input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text">직급</span>
          </div>
          <input type="text" name="position" class="form-control">
        </div>
        <div class="col-md-4 reset-pd input-group input-group-sm input-bg-wh">
          <div class="form-group input-group-prepend"><span class="input-group-text">재직구분</span>
            <label><input type="radio" name="work" value="0" checked="checked">재직중</label>
            <label><input type="radio" name="work" value="1">퇴사</label>
          </div>
        </div>
        <div class="col-md-4 reset-pd input-group input-group-sm input-bg-wh">
          <div class="form-group input-group-prepend"><span class="input-group-text">해외접속</span>
            <label><input type="radio" name="conn" value="0" checked="checked">불가능</label>
            <label><input type="radio" name="conn" value="1">가능</label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 form-inline ">
      <div class="col-2 offset-8 reset-pd">
        <button  class="btn btn-success btn-block" type="button" name="button" onclick='store()'><i class="fas fa-save"></i> 저장</button>
      </div>
      <div class="col-2 reset-pd ">
        <button  class="btn btn-warning btn-block" type="button" name="button" onclick='update()'style="color:white"><i class="fas fa-edit" ></i> 수정</button>
      </div>
    </div>
    <div class="col-md-6 form-inline">
      <div class="col-2 offset-8 reset-pd">
        <button  class="btn btn-success btn-block" type="button" name="button" onclick='store2()'><i class="fas fa-save"></i> 저장</button>
      </div>
      <div class="col-2 reset-pd ">
        <button  class="btn btn-warning btn-block" type="button" name="button" onclick='update2()'style="color:white"><i class="fas fa-edit" ></i> 수정</button>
      </div>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 form-inline">
      <div id="gridEmp"></div>
    </div>
    <div class="col-md-6 form-inline">
      <div id="gridPgm"></div>
    </div>
  </div>
</form>

<iframe name="tFrame" width="0" height="0" scrolling="no" marginheight="0" marginwidth="0"  frameborder="0"  id="tFrame"></iframe>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(){
  search();
  search2();
});
function search(){
  let theForm   = document.main_form;
  let emp_nb    = theForm.emp_nb.value;
  let emp_nm    = theForm.emp_nm.value;
  let part      = theForm.part.value;
  let position  = theForm.position.value;
  let work  = theForm.work.value;
  let conn  = theForm.conn.value;


  let source      = {
    data:{
      emp_nb : emp_nb,
      emp_nm : emp_nm,
      part : part,
      position: position,
      emp_div : work,
      overseas_ny :conn,
      _process:"search",
      _token : $('meta[name="csrf-token"]').attr('content')
    },
    url:'{{$pgm_info->m_pgm_id}}',
    type: "GET",
    cache:false,
    datatype: "json",
    datafields:[
      {name:'emp_nb', type:'string'},
      {name:'emp_nm', type:'string'},
      {name:'part', type:'string'},
      {name:'position', type:'string'},
      {name:'emp_div', type:'string'},
      {name:'overseas_ny', type:'string'}
    ],
  };
  let dataAdapter = new $.jqx.dataAdapter(source);
  $("#gridEmp").jqxGrid({
    columns:[
      {text:'사번', datafield:'emp_nb', width:'10%'},
      {text:'이름', datafield:'emp_nm', width:'20%'},
      {text:'부서', datafield:'part', width:'20%'},
      {text:'직급', datafield:'position', width:'10%'},
      {text:'재직구분', datafield:'emp_div', width:'20%'},
      {text:'해외접속여부', datafield:'overseas_ny', width:'20%'}

    ],
    width: '100%',
    height:'500',
    source:dataAdapter,
    filterable : true,
    sortable:true
  });

  $('#gridEmp') .bind('celldoubleclick', function(event){
    let getRowData = $('#gridEmp').jqxGrid('getrows')[event.args.rowindex];
    let id         = getRowData['emp_nb'];
    let name       = getRowData['emp_nm'];
    let part       = getRowData['part'];
    let position   = getRowData['position'];
    let work   = getRowData['emp_div'];
    let conn   = getRowData['overseas_ny'];
    if(work == "재직중"){
      work=0;
    }else{
      work=1;
    }
    if(conn == "불가능"){
      conn=0;
    }else{
      conn=1;
    }
    theForm.emp_nb.value = id;
    theForm.emp_nm.value = name;
    theForm.part.value = part;
    theForm.position.value = position;
    theForm.work.value = work;
    theForm.conn.value = conn;
    theForm.emp_nb2.value = id;
    theForm.emp_nm2.value = name;
    search2();

  });
}
function store(){
  let theForm   = document.main_form;
  let emp_nb    = theForm.emp_nb.value;
  let emp_nm    = theForm.emp_nm.value;
  let part      = theForm.part.value;
  let position  = theForm.position.value;
  let work  = theForm.work.value;
  let conn  = theForm.conn.value;

  if( emp_nb == "" || emp_nm == "" || part == "" || position == "" ){
    alert("모든 값을 입력해주세요");
  }else if(confirm("저장하시겠습니까?")){
    $.ajax({
      data:{
        emp_nb,emp_nm,  part, position, work, conn,
        _process:"store",
        _token : $('meta[name="csrf-token"]').attr('content')
      },
      url:'{{$pgm_info->m_pgm_id}}',
      type: "POST",
      cache:false,
      datatype: "json",
      success:function(data){
        if(data=="SUCCESS"){
          alert("저장되었습니다");
          search();
        }
        if(data == "ERROR"){
          alert("이미 존재하는 사번입니다. 입력하신 정보를 다시 확인해주세요");
        }
      }
    });
  }
}
function update(){
  let theForm   = document.main_form;
  let emp_nb    = theForm.emp_nb.value;
  let emp_nm    = theForm.emp_nm.value;
  let part      = theForm.part.value;
  let position  = theForm.position.value;
  if( emp_nb == "" || emp_nm == "" || part == "" || position == ""){
    alert("모든 값을 입력해주세요");
  }
  else if(confirm(emp_nm+"님의 정보를 수정 하시겠습니까?")){
    theForm._method.value="PATCH";
    theForm.target = "tFrame";
    theForm.action= "ST01"+"?_process=update";
    theForm.submit();
  }
}
function search2(){
  let theForm   = document.main_form;
  let emp_nb2    = theForm.emp_nb.value;
  let emp_nm2   = theForm.emp_nm.value;
  let source = {
    data : {
      emp_nb2, emp_nm2,
      _process : "search2"
    },
    url:'{{$pgm_info->m_pgm_id}}',
    type: "GET",
    cache:false,
    datatype: "json",
    datafields:[
      {name:'pgm_id', type:'string'},
      {name:'m_pgm_nm', type:'string'},
      {name:'permit', type:'bool'},
    ],
  };
  let dataAdapter = new $.jqx.dataAdapter(source);
  $("#gridPgm").jqxGrid({
    columns:[
      {text:'프로그램ID', datafield:'pgm_id', width:'30%',editable:false},
      {text:'프로그램명', datafield:'m_pgm_nm', width:'30%',editable:false},
      {text: '권한',datafield: 'permit',width: '9%',align: 'center', columntype: 'checkbox'},
    ],
    width: '100%',
    height:'500',

    source:dataAdapter,
    filterable : true,
    sortable:true,
    editable: true,
  });


}
function store2(){
  let theForm   = document.main_form;
  let emp_nb2    = theForm.emp_nb2.value;
  let gridPgm = JSON.stringify($('#gridPgm').jqxGrid('getrows'));
  // theForm.gridPgmData.value = gridPgm;
  $.ajax({
    data:{
      emp_nb2,
      gridPgm,
      _process:"store2",
      _token : $('meta[name="csrf-token"]').attr('content')
    },
    url:'{{$pgm_info->m_pgm_id}}',
    type: "POST",
    cache:false,
    datatype: "json",
    success:function(data){
      if(data == 'success'){
        alert('저장되었습니다');
      }
      if(data == 'error'){
        alert('이미 권한이 설정된 사번입니다. 변경을 원하시면 수정버튼을 눌러주세요.');
      }
    }
  });

}
function update2(){
  let theForm = document.main_form;
  let emp_nb2 = theForm.emp_nb2.value;
  let gridPgm = JSON.stringify($('#gridPgm').jqxGrid('getrows'));
  $.ajax({
    data:{
      emp_nb2,
      gridPgm,
      _process:"update2",
      _token : $('meta[name="csrf-token"]').attr('content')
    },
    url:'{{$pgm_info->m_pgm_id}}',
    type: "PATCH",
    cache:false,
    datatype: "json",
    success:function(data){
      if(data == 'success'){
        alert('수정되었습니다');
      }
      if(data == 'error'){
        alert('권한을 최초 저장 후 수정해주세요.');
      }
    }
  });
}
</script>
