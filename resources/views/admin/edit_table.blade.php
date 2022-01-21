@include('admin.header',['Title'=>"Admin - Index"])
<div class="container mt-4">
  <div class="ps-5 my-3 h3">
    {{$Title}}
  </div>
  @if (session('status'))
      <h6 class="alert alert-success" id="status">{{ session('status') }}</h6>
  @endif
  @if (session('danger'))
      <h6 class="alert alert-danger" id="status">{{ session('danger') }}</h6>
  @endif
  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
  <div style="transform: rotateX(180deg);overflow-x: auto;">
    <table class="table table-striped" style="transform: rotateX(180deg);">
      <tr class="table-dark">
        @foreach($TableName as $table)
            <th>{{$table}}</th>
        @endforeach
        <td colspan="2"></td>
      </tr>
      @foreach($Table as $column)
        <tr>
            @foreach($column->toArray() as $key=>$value)
            <td>{{$value}}</td>
            @endforeach
            <td><button class="btn btn-primary border border-2" data-bs-toggle="modal" data-bs-function="edit" data-bs-id="{{$loop->index}}" data-bs-target="#exampleModal"><i class="bi bi-pencil-square"></i></button></td>
            <td><button class="btn btn-danger border border-2 delete_table" value="{{$loop->index}}"><i class="bi bi-trash"></i></button></td>
          </tr>
      @endforeach
      <tr>
        <td colspan="100%" class="text-center">
          <button class="btn mx-auto w-100 border rounded-pill border-3" data-bs-toggle="modal" data-bs-function="add" data-bs-target="#exampleModal">
            <i class="bi bi-plus-circle"></i>
          </button>
        </td>
      </tr>
    </table>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="updateForm" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalInput">
        {{-- <div class="row mb-5 px-3">
            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
            Course Name:
            </label>
            <div class="col-8 mx-auto"><input type="text" class="form-control w-100" id="modalCourseName" name="courseNameModal"></div>
        </div> --}}
      </div>
      <div id="noneditableInput"></div>
      <input style="display:none" name="table" value="{{$tbl}}">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
        <button type="submit" name="action" value="submit" class="btn btn-primary" id="modalButtonType">Create</button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  var exampleModal = document.getElementById('exampleModal');
  exampleModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var method = button.getAttribute('data-bs-function');
      if(method=="edit"){
        document.getElementById("exampleModalLabel").innerHTML="Edit";
        document.getElementById("modalButtonType").innerHTML="Update";
        exampleModal.querySelector('#modalButtonType').setAttribute('value','edit');
        exampleModal.querySelector('#updateForm').setAttribute('action','{{route('update_admin_table')}}');
        var id = button.getAttribute('data-bs-id');
        var array = (<?php echo json_encode($Table)?>)[id];
        exampleModal.querySelector('#modalInput').innerHTML="";
        exampleModal.querySelector('#noneditableInput').innerHTML="";
        Object.keys(array).filter(function(key){
          var ignoreList = ['created_at','updated_at','save'];
          var noneditableList = ['id'];
          if(ignoreList.includes(key)==false){
            var index = array[key];
            if(noneditableList.includes(key)==true){
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(key,index,false,"","");
            }else if(key=='type'){
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(key,index,true,"promo_type","");
            }else{
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(key,index,true,"","");
            }
          }
        });
      }else if(method==("add")){
        document.getElementById("exampleModalLabel").innerHTML="Add";
        document.getElementById("modalButtonType").innerHTML="Create";
        exampleModal.querySelector('#modalButtonType').setAttribute('value','create');
        exampleModal.querySelector('#updateForm').setAttribute('action','{{route('update_admin_table')}}');
        var array = (<?php echo json_encode($TableName)?>);
        exampleModal.querySelector('#modalInput').innerHTML="";
        exampleModal.querySelector('#noneditableInput').innerHTML="";
        Object.keys(array).filter(function(key){
          var index = array[key];
          var ignoreList = ['id','created_at','updated_at'];
          var noneditableList = [];
          var optionList = ['user_id','class_id','category_id'];
          var timeList = ['expired_at','created_at','updated_at'];
          if(ignoreList.includes(index)==false){
            if(noneditableList.includes(index)==true){
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(index,"",false,"","");
            }else if(optionList.includes(index)==true){
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(index,"",true,"option","");
            }else if(timeList.includes(index)==true){
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(index,"",true,"time","");
            }else if(index=='type'){
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(index,"",true,"promo_type","");
            }else{
              exampleModal.querySelector('#modalInput').innerHTML+=addInput(index,"",true,"","");
            }
          }
        });
        // exampleModal.querySelector('#modalInput').innerHTML="";
        // exampleModal.querySelector('#noneditableInput').innerHTML="";
        // Object.keys(array).filter(function(key){
        //   var ignoreList = ['created_at','updated_at','save'];
        //   var noneditableList = ['id'];
        //   if(ignoreList.includes(key)==false){
        //     var index = array[key];
        //     if(noneditableList.includes(key)==true){
        //       exampleModal.querySelector('#modalInput').innerHTML+=addInput(key,index,false,"","");
        //     }else{
        //       exampleModal.querySelector('#modalInput').innerHTML+=addInput(key,index,true,"","");
        //     }
        //   }
        // });
      }
      
      // ((<?php echo json_encode($Table)?>)[id]).foreach(element=>{
      //   console.log(element);
      // });
      // for (let i = 0; i <= (<?php echo json_encode($Table) ?>).length-1; i++) {
      //   console.log((<?php echo json_encode($Table) ?>[i]));
      // }
      // var modalTitle = exampleModal.querySelector('.modal-title')
      // var modalCourseName = exampleModal.querySelector('#modalCourseName')
      // var modalCourseInfo = exampleModal.querySelector('#modalCourseInfo')
      // var modalButtonType = exampleModal.querySelector('#modalButtonType')
      // var modalBtnDelete = exampleModal.querySelector('#modalBtnDelete')
      // var modalCourseVideoVisible = exampleModal.querySelector('#modalCourseVideoVisible')
      // var updateForm = exampleModal.querySelector('#updateForm')
      // if(recipient=='@editCourseModal'){
      //     modalTitle.textContent = "Edit Class"
      //     modalCourseName.value = name
      //     modalCourseInfo.value = info
      //     modalButtonType.innerHTML = "Update"
      //     updateForm.setAttribute('action','/updateCourseInfo/'+courseId)
      //     modalCourseVideoVisible.style.display = 'inline'
      //     modalBtnDelete.style.display = 'inline'
      //     modalCourseVideoVisible.innerHTML = "<video controls disablePictureInPicture controlsList='nodownload' class='card-img-top w-100'><source src='"+path+"' type='video/mp4'>Your browser does not support the video tag.</video>"
      // }else if(recipient=="@newCourseModal"){
      //     modalTitle.textContent = "New Class"
      //     modalCourseName.value = ""
      //     modalCourseInfo.value = ""
      //     modalButtonType.innerHTML = "Create"
      //     modalButtonType.setAttribute('value','create')
      //     updateForm.setAttribute('action','/updateCourseInfo/'+classId)
      //     modalBtnDelete.style.display = 'none'
      //     modalCourseVideoVisible.style.display = 'none'
      // }
      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
  });

  function addInput(name,value,editable,type,placeholder){
    var input="<div class='row mb-3 px-3'><label class='form-check-label col-4 my-auto' for='flexCheckDefault'>"+name+":</label><div class='col-8 mx-auto'>";
    if(type=="textarea"){
      input+="<textarea maxlength='150' name='"+name+"' class='form-control' rows='5' style='resize:none;' placeholder='"+placeholder+"'></textarea>";
    }else if(type=="option"){
      input+="<select class='form-select' name='"+name+"'>";
      var array2;
      if(name=='category_id'){
        array2 = (<?php echo json_encode($category_id)?>);
      }else if(name=='user_id'){
        array2 = (<?php echo json_encode($user_id)?>);
      }else if(name=='class_id'){
        array2 = (<?php echo json_encode($class_id)?>);
      }
      Object.keys(array2).filter(function(key){
        input+="<option value='"+array2[key]['id']+"'>";
        if(name=='user_id'){
          input+=array2[key]['username'];
        }else{
          input+=array2[key]['name'];
        }
        input+=" ( id:"+array2[key]['id']+" )"+"</option>";
      });
      input+="</select>";
    }else if(type=='time'){
      input+="<input type='datetime-local' name='"+name+"'>";
    }else if(type=='promo_type'){
      input+="<select class='form-select' name='"+name+"'><option value='1'";
      if(value==1){
        input+="selected";
      }
      input+=">1 - Amount</option><option value='2'";
      if(value==2){
        input+="selected";
      }
      input+=">2 - Percentage</option></select>";
    }else{
      input+="<input type='text'";
      if(editable==false){
        input+=" disabled ";
        exampleModal.querySelector('#noneditableInput').innerHTML+="<input style='display:none' name='"+name+"' value='"+value+"'>";
      }
      input+="class='form-control w-100' name='"+name+"' value='"+value+"'>";
    }
    input+="</div></div>";
    return input;
  }
  // exampleModal.addEventListener('hidden.bs.modal', function (event) {
  //     modalCourseVideoVisible.innerHTML = ''
  // })

  // document.getElementById('classThumbnail').onchange = evt => {
  //     const [file] = document.getElementById('classThumbnail').files;
  //     if (file) {
  //          document.getElementById('imgThumbnail').src = URL.createObjectURL(file);
  //     }
  // }

  // setInputFilter(document.getElementById("inputNumber"), function(value) {
  //     return /^-?\d*[.]?\d{0,2}$/.test(value); 
  // });

</script>
@include('admin.footer')