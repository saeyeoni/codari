
<form name="main_form" method="post">
  @csrf
  <input type="hidden" name="_method" value="">
@isset($pgm_info)
  <h5 class="page-head-line">
    {{ $pgm_info->m_pgm_nm  }} ({{$pgm_info->m_pgm_id}})
  </h5>
@endisset

  <div class="row">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text">작성일</span></div>
      <input class="form-control" type="text" name="date" value="{{ isset($id) ? $id->created_at : date("Y-m-d")}}" readonly="readonly">
      <div class="input-group-prepend"><span class="input-group-text">작성부서</span></div>
      <input class="form-control" type="text" name="part" value="{{ isset($id) ? $id->empmaster->part : Session::get('emp_part')}}" readonly="readonly">
      <div class="input-group-prepend"><span class="input-group-text">작성자</span></div>
      <input class="form-control" type="text" name="name" value="{{ isset($id) ? $id->empmaster->emp_nm : Session::get('emp_part')}}" readonly="readonly">
    </div>
  </div>
  <div class="row">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span">브랜드</span></div>
        @if(isset($id))
          <input class="form-control" type="text" name="name" value="{{ $id->brand->nm }}" readonly="readonly">
        @else
          {{-- <select class="regist-sel form-control" name="brand_id" id="brand_id">
            <option value="{{  isset($id) ? $id->brand_id : "" }}" selected>{{  isset($id) ? $id->brand->nm : "" }}</option>
          </select> --}}
          <select class="regist-sel form-control" name="brand_id" id="brand_id">
            <option value="" selected></option><option value="direct" >직접입력</option>'
          </select>
          <input class="form-control" readonly="readonly" type="text" name="direct_brand" value="" placeholder="브랜드추가" />
        @endif
    </div>
  </div>
  <div class="row">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span">작성유형</span></div>
      @if (isset($id))
        <input class="form-control" type="text" name="name" value="{{ $id->note_type }}" readonly="readonly">
      @else
        <select class="regist-sel form-control" name="note_type" id="note_type" onchange="changeSel(this)">
          <option value="" selected ></option>
          <option value="0" >브랜드기조</option>
          <option value="1">신규런칭아이템</option>
          <option value="2">Proposal map</option>
          <option value="3">Proposal entry</option>
          <option value="4">Project Map</option>
        </select>
      @endif
      @if(isset($id))
        <div class="input-group-sm form-inline" style="visibility:{{ $id->map_name== '' ? 'hidden' : 'visible'}}" name="project"  id="project">
          <div class="input-group-prepend"><span class="input-group-text regist-span">프로젝트 명</span></div>
          <input class="form-control" type="text" name="name" value="{{ $id->map_name }}" readonly="readonly">
        </div>
        @else
          <div class="input-group-sm form-inline" style="visibility:hidden" name="project"  id="project">
            <div class="input-group-prepend"><span class="input-group-text regist-span">프로젝트 명</span></div>
            <select class="regist-sel form-control" name="sel_pj" id="sel_pj" ></select>
          <input class="form-control" readonly="true" type="text" name="direct_sel_pj" value="" placeholder="Project Map 추가">
        @endif
      </div>
  </div>
</div>

@if(isset($id))
  <div class="row" style="visibility:{{ $id->use_type== '　' ? 'hidden' : 'visible'}}" id="use">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span">사용군/소제목</span></span></div>
      <input class="form-control" type="text" name="name" value="{{ $id->use_type }}" readonly="readonly">
    </div>
  </div>
@else
  <div class="row" style="visibility:hidden" id="use">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span">사용군/소제목</span></span></div>
      <select class="regist-sel form-control" name="use_type" id="use_type" onchange="changeType(this)"></select>
      <input class="form-control" readonly="readonly" type="text" name="direct_use_type" value="" placeholder="사용군 추가">
    </div>
  </div>
@endif

@if(isset($id))
  <div class="row"style="visibility:{{ $id->prd_type== '　' ? 'hidden' : 'visible'}}" id="prd">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span">제품군</span></span></div>
      <input class="form-control" type="text" name="name" value="{{ $id->prd_type }}" readonly="readonly">
    </div>
  </div>
@else
  <div class="row"style="visibility:hidden" id="prd">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span">제품군</span></span></div>
      <select class="regist-sel form-control" name="prd_type" id="prd_type">
      </select>
      <input class="form-control" readonly="true" type="text" name="direct_prd_type" value="" placeholder="제품군 추가">
    </div>
  </div>
@endif

  <div class="row">
    <div class="col-md-12 input-group-sm form-inline">
    @if(isset($id))
      <br>
    @else
      <label><input class="form-control" type="checkbox" name="first_div" value="1">새로운열에추가</label>
    @endif
    </div>
  </div>
  <div class="row">
    <div class=" col-md-12 input-group-sm form-inline">
      <textarea name="content" id="content" rows="20" cols="100" placeholder="">{{isset($id) ? $id->content : ''}}</textarea>
    </div>
    <div class="col-md-12 form-inline">
        @if (isset($id))
        <div class="col-sm-3 offset-3 reset-pd" >
          <button  class="btn btn-warning btn-block" type="button" name="button" onclick='updateNote()'><i class="fas fa-edit"></i> 수정</button>
        </div>
        <div class="col-sm-3  reset-pd" >
          <button  class="btn btn-danger btn-block" type="button" name="button" onclick='deleteNote()'><i class="fas fa-trash-alt"></i> 삭제</button>
        </div>
        @else
          <div class="col-md-6">
            <div class="col-md-2 offset-4 reset-pd" >
              <button  class="btn btn-success btn-block" type="button" name="button" onclick='store()'><i class="fas fa-save"></i> 저장</button>
            </div>
          </div>

        @endif
    </div>
  </div>
</form>
{{-- 수정팝업의 수정history --}}
@isset($history_list)
  <div class="row" style="margin-top:10px;">
    <div class="col-12">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width:5vw; text-align:center;">#</th>
            <th style="width:25vw; text-align:center;">수정날짜</th>
            <th style="width:70vw; text-align:center;">내용</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $history_list as $i=>$history)
          <tr>
            <th style="text-align:center;">{{ (count($history_list))-1-$i }}</th>
            <td style="text-align:center;">{{$history->created_at}}</td>
            <td>{{$history->content}}</td>
          </tr>
        @endforeach

        </tbody>
      </table>
    </div>
  </div>
@endisset
<iframe name="tFrame" width="0" height="0" scrolling="no" marginheight="0" marginwidth="0"  frameborder="0"  id="tFrame"></iframe>

<script type="text/javascript">
window.addEventListener("DOMContentLoaded", function(){
  getBrands();
  readOnlyBool('sel_pj', 'direct_sel_pj');
  readOnlyBool('use_type', 'direct_use_type');
  readOnlyBool('prd_type', 'direct_prd_type');
  readOnlyBool('brand_id', 'direct_brand');
});

function readOnlyBool(selectType,inputName){
  document.querySelector("select[name='"+selectType+"']").addEventListener('change', function(event){
    if(document.querySelector("select[name='"+selectType+"']").value=="direct"){
      // document.querySelector("select[name='"+selectType+"']").removeAttribute('readonly');
      document.querySelector("input[name='"+inputName+"']").readOnly=false;
    }else{
      document.querySelector("input[name='"+inputName+"']").readOnly=true;
    }
  });
}
function getBrands(){
  $.ajax({
    type: "GET",
    url: "{{ route('overbrands')}}",
    data: {
      _process:"getbrands",
      _token : $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: "json",
    success: function(data) {
      for(i=0; i<data.brands.length; i++){
        let options = document.createElement("option");
        options.text =data.brands[i].nm;
        options.value = data.brands[i].id;
        document.getElementById("brand_id").appendChild(options);
      }
    }
  });
}
function changeType(e){
  let sel_name =e.name;
  let op_value = e.value;
  let ut_op_text =""
  let ut_op_value =""

  if(sel_name=="use_type"){
    ut_op_value = document.querySelector("#note_type").options[document.querySelector("#note_type").selectedIndex].value;
    ut_op_text = document.querySelector("#use_type").options[document.querySelector("#use_type").selectedIndex].text;
  }

  let directOption ='<option value="" selected></option><option value="direct" >직접입력</option>';
  let totalOption = '<option value="총평" >총평</option>';
  $.ajax({
    type: "GET",
    url: "{{ route('overitems')}}",
    data: {
      op_value,
      ut_op_value,
      ut_op_text,
      _process: sel_name,
      _token : $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: "json",
    success: function(data) {
      if(sel_name=="note_type"){
        document.getElementById("use_type").innerHTML = directOption+totalOption;
        for(i=0; i<data.result.length; i++){
          let options = document.createElement("option");
          options.text = data.result[i].use_type;
          options.value = data.result[i].use_type;
          document.getElementById("use_type").appendChild(options);
        }
        document.getElementById("sel_pj").innerHTML = directOption;
        for(i=0; i<data.map.length; i++){
          let options = document.createElement("option");
          options.text = data.map[i].map_name;
          options.value = data.map[i].map_name;
          document.getElementById("sel_pj").appendChild(options);
        }
      }
      if(sel_name=="use_type"){
        if(ut_op_value =='0' || ut_op_value=='1'){
          document.getElementById("prd").style.visibility="visible";
          if(op_value != "total"){
            document.getElementById("prd_type").innerHTML = directOption;
            for(i=0; i<data.result.length; i++){
              let options = document.createElement("option");
              options.text = data.result[i].prd_type;
              options.value = data.result[i].prd_type;
              document.getElementById("prd_type").appendChild(options);
            }
          }else{
            document.getElementById("prd").style.visibility="hidden";
          }
        }
      }
    }
  });
}
function changeSel(e){
  document.querySelector("textarea[name=content]").innerHTML="";
  document.getElementById("use").style.visibility="hidden";
  document.getElementById("prd").style.visibility="hidden";
  document.getElementById("project").style.visibility="hidden";
  if(e.value == '0' || e.value == '1'){
    document.getElementById("use").style.visibility="visible";
    document.getElementById("prd").style.visibility="visible";
  }else if(e.value == '4'){
    document.getElementById("project").style.visibility="visible";
  }else{
    document.getElementById("use").style.visibility="visible";
  }
  changeType(e);
}
function store(){
  let theForm   = document.main_form;
  let vSet = [];
  if(document.querySelector("select[name='note_type']").value==4){
    vSet.push(["select","sel_pj","프로젝트 맵 ","empty"]);
  }else{
    vSet.push(["select","use_type","사용군 선택","empty"]);
  }
  if(document.querySelector("input[name='direct_sel_pj']").readOnly==false){
    vSet.push(["input","direct_sel_pj","프로젝트 맵 ","empty"]);
  }
  if(document.querySelector("input[name='direct_use_type']").readOnly==false){
    vSet.push(["input","direct_use_type","사용군","empty"]);
  }
  if(document.querySelector("input[name='direct_prd_type']").readOnly==false){
    vSet.push(["input","direct_prd_type","제품군","empty"]);
  }
  if(document.querySelector("input[name='direct_brand']").readOnly==false){
    vSet.push(["input","direct_brand","브랜드","empty"]);
  }
  vSet.push(["select","brand_id","브랜드 선택","empty"]);
  vSet.push(["select","note_type","작성유형 선택","empty"]);
  vSet.push(["textarea","content","내용","empty"]);
  @isset($pgm_info)
  if(validation(vSet)==true){
    theForm.target = "tFrame";
    theForm.action= "{{$pgm_info->m_pgm_id}}"+"?pgm=overseas";
    theForm.submit();
  }
  @endisset
}
function updateNote(){
  let theForm  = document.main_form;
  theForm._method.value="PATCH";
  theForm.submit();
}
function deleteNote(){
  let theForm  = document.main_form;
  theForm._method.value="DELETE";
  theForm.submit();
}
function clear(){
   location.reload();
}

</script>
