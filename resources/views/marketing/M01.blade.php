{{-- 등록창과 수정창이 같은 폼으로 $id 존재 여부로 나뉜다 --}}
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
      <input class="form-control" type="text" name="date" value="{{ isset($id) ? date("Y-m-d" , strtotime($id->created_at)) : date("Y-m-d")}}" readonly="readonly">
      <div class="input-group-prepend"><span class="input-group-text">작성부서</span></div>
      <input class="form-control" type="text" name="part" value="{{ isset($id) ? $id->empmaster->part : Session::get('emp_part')}}" readonly="readonly">
      @if(empty($id))
        <div class="input-group-prepend"><span class="input-group-text">작성자</span></div>
        <input class="form-control" type="text" name="name" value="{{ Session::get('emp_nm')}}" readonly="readonly">
      @endif
    </div>
  </div>
  <div class="row">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span ">브랜드</span></div>
      @if(isset($popup_div))
        @if($popup_div=='edit')
          <input class="form-control" type="text" name="name" value="{{ $id->brand->nm }}" readonly="readonly">
        @else
          <input class="form-control" type="text" name="regist_brand_nm" value="" readonly="readonly">
          <input class="form-control" type="hidden" name="regist_brand_id" >
        @endif
      @else
        <select class="regist-sel form-control" name="brand_id" id="brand_id" onchange="changeBrand()">
          <option value="" selected></option><option value="direct" >직접입력</option>'
        </select>
        <input class="form-control" readonly="readonly" type="text" name="direct_brand" value="" placeholder="브랜드추가" />
      @endif
    </div>
  </div>
  <div class="row">
    <div class=" col-md-12 input-group-sm form-inline">
      <div class="input-group-prepend"><span class="input-group-text regist-span">작성유형</span></div>
      @if(isset($popup_div))
        @if ($popup_div=='edit')
          <input class="form-control" type="text" name="name" value="{{ $id->note_type }}" readonly="readonly">
        @else
          <input class="form-control" type="text" name="regist_note_type" value="" readonly="readonly">
        @endif
      @else
        <select class="regist-sel form-control" name="note_type" id="note_type" onchange="changeSel(this)">
          <option value=""  ></option>
          <option value="0" >브랜드기조</option>
          <option value="1">신규런칭아이템</option>
          <option value="2">Proposal map</option>
          <option value="3">Proposal entry</option>
          <option value="4">Project Map</option>
        </select>
      @endif
      @if(isset($popup_div))
        @if($popup_div=='edit')
          <div class="input-group-sm form-inline" style="visibility:{{ $id->map_name== '' ? 'hidden' : 'visible'}}" name="project"  id="project">
            <div class="input-group-prepend"><span class="input-group-text regist-span">프로젝트 명</span></div>
            <input class="form-control" type="text" name="name" value="{{ $id->map_name }}" readonly="readonly">
          </div>
        @else
          <div class="input-group-sm form-inline" style="visibility:hidden" name="project"  id="project">
            <div class="input-group-prepend"><span class="input-group-text regist-span">프로젝트 명</span></div>
            <input class="form-control" type="text" name="regist_map_name" value="" readonly="readonly">
          </div>
        @endif
      @else
        <div class="input-group-sm form-inline" style="visibility:hidden" name="project"  id="project">
          <div class="input-group-prepend"><span class="input-group-text regist-span">프로젝트 명</span></div>
          <select class="regist-sel form-control" name="sel_pj" id="sel_pj" ></select>
          <input class="form-control" readonly="true" type="text" name="direct_sel_pj" value="" placeholder="Project Map 추가">
        @endif
      </div>
    </div>
  </div>

  @if(isset($popup_div))
    @if($popup_div=='edit')
      <div class="row" style="visibility:{{ $id->use_type== '' ? 'hidden' : 'visible'}}" id="use">
        <div class=" col-md-12 input-group-sm form-inline">
          <div class="input-group-prepend"><span class="input-group-text regist-span">사용군/소제목</span></span></div>
          <input class="form-control" type="text" name="name" value="{{ $id->use_type }}" readonly="readonly">
        </div>
      </div>
    @else
      <div class="row" style="visibility:hidden" id="use">
        <div class=" col-md-12 input-group-sm form-inline">
          <div class="input-group-prepend"><span class="input-group-text regist-span">사용군/소제목</span></span></div>
          <input class="form-control" type="text" name="regist_use_type" readonly="readonly">
        </div>
      </div>
    @endif
  @else
    <div class="row" style="visibility:hidden" id="use">
      <div class=" col-md-12 input-group-sm form-inline">
        <div class="input-group-prepend"><span class="input-group-text regist-span">사용군/소제목</span></span></div>
        <select class="regist-sel form-control" name="use_type" id="use_type" onchange="changeOption(this)"></select>
        <input class="form-control" readonly="readonly" type="text" name="direct_use_type" value="" placeholder="사용군 추가">
      </div>
    </div>
  @endif

  @if(isset($popup_div))
    @if($popup_div=='edit')
      <div class="row"style="visibility:{{ $id->prd_type== '' ? 'hidden' : 'visible'}}" id="prd">
        <div class=" col-md-12 input-group-sm form-inline">
          <div class="input-group-prepend"><span class="input-group-text regist-span">제품군</span></span></div>
          <input class="form-control" type="text" name="name" value="{{ $id->prd_type }}" readonly="readonly">
        </div>
      </div>
    @else
      <div class="row"style="visibility:hidden" id="prd">
        <div class=" col-md-12 input-group-sm form-inline">
          <div class="input-group-prepend"><span class="input-group-text regist-span">제품군</span></span></div>
          <input class="form-control" type="text" name="regist_prd_type" value="" readonly="readonly">
        </div>
      </div>
    @endif
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

  {{-- <div class="row">
  <div class="col-md-12 input-group-sm form-inline">
  @if(isset($id))
  <br>
@else
<label><input class="form-control" type="checkbox" name="first_div" value="1">새로운열에추가</label>
@endif
</div>
</div> --}}
<div class="row">
  <div class=" col-md-12 input-group-sm form-inline">
    <textarea name="content" id="content" rows="20" cols="100" placeholder="">{{isset($id) ? $id->content : ''}}</textarea>
  </div>
  <div class="col-md-12 form-inline">
    @if(isset($popup_div))
      @if ($popup_div=='edit')
        <div class="col-sm-3 reset-pd back-btn" >
          <button  class="btn btn-primary btn-block" type="button" name="button" onclick="javascript:history.back()"><i class="fas fa-undo"></i> 뒤로가기</button>
        </div>
        @if(Str::contains('M02',$edit_permit))
          <div class="col-sm-3 reset-pd" >
            <button  class="btn btn-warning btn-block" type="button" name="button" onclick="updateNote()"><i class="fas fa-edit"></i> 수정</button>
          </div>
          @if(Session::get('login_grade') == 1 )
            <div class="col-sm-3  reset-pd" >
              <button  class="btn btn-danger btn-block" type="button" name="button" onclick='deleteNote()'><i class="fas fa-trash-alt"></i> 삭제</button>
            </div>
          @endif
        @endif
      @else
        <div class="col-sm-4 reset-pd back-btn">
          <button  class="btn btn-primary btn-block" type="button" name="button" onclick="javascript:history.back()"><i class="fas fa-undo"></i>뒤로가기</button>

        </div>
        <div class="col-sm-4 reset-pd">
          <button  class="btn btn-success btn-block" type="button" name="button" onclick="store('direct_store')"><i class="fas fa-save"></i> 저장</button>
        </div>
      @endif
    @else
      <div class="col-md-2 reset-pd" >
        <button  class="btn btn-primary btn-block" type="button" name="button" onclick="javascript:history.back()"><i class="fas fa-undo"></i> 뒤로가기</button>
      </div>
      <div class="col-md-2 reset-pd" >
        <button  class="btn btn-success btn-block" type="button" name="button" onclick="store('store')"><i class="fas fa-save"></i> 저장</button>
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
            <th style="width:60vw; text-align:center;">내용</th>
            <th style="width:10vw; text-align:center;">작성자</th>

          </tr>
        </thead>
        <tbody>
          @foreach( $history_list as $i=>$history)
            <tr>
              <th style="text-align:center; vertical-align:middle">{{ (count($history_list))-1-$i }}</th>
              <td style="text-align:center; vertical-align:middle">{{date("Y-m-d" , strtotime($history->created_at))}}</td>
              <td ><pre style="width:60vw;">{{$history->content}}</pre></td>
              <td style="text-align:center; vertical-align:middle">{{$history->empmaster->emp_nm}}</td>
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
  let filter = "win16|win32|win64|mac";
  if(navigator.platform){
    if(0 > filter.indexOf(navigator.platform.toLowerCase())){
      $(".back-btn").css({"display" : "block"});
    }
  }
  @if(isset($popup_div))
  @if($popup_div == 'save')
  getSelectInfo('direct_store');
  @endif
  @else
  getBrands('store');
  readOnlyBool('sel_pj', 'direct_sel_pj');
  readOnlyBool('use_type', 'direct_use_type');
  readOnlyBool('prd_type', 'direct_prd_type');
  readOnlyBool('brand_id', 'direct_brand');
  @endif
});

function getSelectInfo(){
  let getBrand_id = opener.document.querySelector("input[name='regist_brand_nm']").value;
  let getNote_type = opener.document.querySelector("input[name='regist_note_type']").value;
  getBrands('direct_store',getBrand_id,function(result){
    document.querySelector("input[name='regist_brand_nm']").value = result;
  });
  switch (getNote_type) {
    case '브랜드기조':
    case '신규런칭아이템':
    document.getElementById("use").style.visibility="visible";
    document.getElementById("prd").style.visibility="visible";
    break;
    case 'Proposal map':
    case 'Proposal entry':
    document.getElementById("use").style.visibility="visible";
    break;
    case 'Project Map':
    document.getElementById("project").style.visibility="visible";
    break;
  }
  document.querySelector("input[name='regist_brand_id']").value = getBrand_id;
  document.querySelector("input[name='regist_note_type']").value = opener.document.querySelector("input[name='regist_note_type']").value;
  document.querySelector("input[name='regist_use_type']").value = opener.document.querySelector("input[name='regist_use_type']").value;
  document.querySelector("input[name='regist_prd_type']").value = opener.document.querySelector("input[name='regist_prd_type']").value;
  document.querySelector("input[name='regist_map_name']").value = opener.document.querySelector("input[name='regist_map_name']").value;


}
function readOnlyBool(selectType,inputName){
  document.querySelector("select[name='"+selectType+"']").addEventListener('change', function(event){
    if(document.querySelector("select[name='"+selectType+"']").value=="direct"){
      document.querySelector("input[name='"+inputName+"']").readOnly=false;
    }else{
      document.querySelector("input[name='"+inputName+"']").value="";
      document.querySelector("input[name='"+inputName+"']").readOnly=true;
    }
  });
}

//콜백함수로 정의, direct저장시 브랜드id에 따른 name을 가져올때 비동기식처리를 위해 콜백함수로 정의, 마켓
function getBrands(param,brand_id,callback){
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
      switch(param){
        case 'store':
        for(i=0; i<data.brands.length; i++){
          let options = document.createElement("option");
          if(data.brands[i].brand!=null){           //brand_master의 use_yn값이 1(삭제상태)이면 brand값이 널이다
            options.text =data.brands[i].brand.nm;
            options.value = data.brands[i].brand.id;
            document.getElementById("brand_id").appendChild(options);
          }
        }
        break;
        case 'direct_store':
        for(i=0; i<data.brands.length; i++){
          if(data.brands[i].brand_id == brand_id){
            callback( data.brands[i].brand.nm);
          }
        }
        break;
      }
    }
  });
}
function changeBrand(){
  changeSel(document.querySelector("#note_type"));
}
// 노트타입 변경시 보여지는 select 변경
function changeSel(e){
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
  changeOption(e);
}
//select usetype option선택 이벤트
function changeOption(e){
  let sel_name =e.name;
  let op_value = e.value;
  let ut_op_text =""
  let ut_op_value =""
  let brand_id = document.querySelector("#brand_id").options[document.querySelector("#brand_id").selectedIndex].value;
  if(sel_name=="use_type"){
    ut_op_value = document.querySelector("#note_type").options[document.querySelector("#note_type").selectedIndex].value;
    ut_op_text = document.querySelector("#use_type").options[document.querySelector("#use_type").selectedIndex].text;
  }

  let directOption ='<option value="" selected></option><option value="direct" >직접입력</option>';
  let totalOption = '<option value="총평" >총평</option>';
  $.ajax({
    type: "GET",
    url: "{{ route('items')}}",
    data: {
      op_value,
      ut_op_value,
      ut_op_text,
      brand_id,
      pgm:'marketing',
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
          if(op_value != "총평"){
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

function store(param){
  let theForm   = document.main_form;
  let vSet = [];
  if(param == 'store'){
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
      theForm.action= "{{$pgm_info->m_pgm_id}}"+"?pgm=marketing&process=store";
      theForm.submit();
    }
    @endisset
  }else if(param == 'direct_store'){
    vSet.push(["textarea","content","내용","empty"]);
    if(validation(vSet)==true){
      theForm.action= "/marketing/M01"+"?pgm=marketing&process=direct_store";
      theForm.submit();
    }
  }else{
    alert("시스템ERROR, 관리자에게 문의하세요.")
  }

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
