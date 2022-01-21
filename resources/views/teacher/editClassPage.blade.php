@include('header',['Title'=>"Edit Class Page"])

<nav class="col offset-1 my-5 ps-2" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('teacherMain')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<div class="card border border-5 col-10 container p-sm-4 p-0" style="border-radius: 1rem;">
    <div class="row card-body gx-5 row-cols-1 px-auto">
        <div class="col-sm-12 col-12 mb-sm-0 mb-3">
            <label class="fs-3 mb-3">Edit Class</label>
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
            <div class="card">
                <form class="card-body p-5 row" id="updateForm" action="/updateClassInfo/{{$ClassInfo->class_id}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3 col-12 col-lg-6">
                        <input type="text" class="form-control" name="className" value="{{$ClassInfo->class_name}}">
                        <label class="ms-3" for="floatingInput">Class Name</label>
                    </div>
                    <div class="form-floating mb-3 col-12 col-lg-5">
                        <input type="file" accept="image/*" class="form-control" id="classThumbnail" name="classThumbnail">
                        <label class="ms-3" for="floatingInput">Class Thumbnail</label>
                    </div>
                    <div class="form-floating mb-3 col-12 col-lg-1">
                        @isset($ClassInfo->class_thumbnail)
                        <img id="imgThumbnail" src="{{ url('storage/classThumbnail/'.$ClassInfo->class_thumbnail) }}" onerror="this.onerror=null; this.src='{{url('storage/classThumbnail/image-not-found.png')}}'" style="width:100%; height:auto;" class="border">
                        @else
                        <img id="imgThumbnail" src="{{url('storage/classThumbnail/image-not-found.png')}}" style="width:100%; height:auto;" class="border">
                        @endisset
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputNumber" name="price" value="{{$ClassInfo->price}}">
                            <label class="ms-1" for="floatingInput">Class Price</label>
                    </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="classCategory" aria-label="Floating label select example">
                                @foreach ($CategoryInfo as $category)
                                <option value="{{$category->category_id}}"
                                    @if ($category->category_name == ($ClassInfo->category_name))
                                        selected="selected"
                                    @endif
                                    >{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Category</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" maxlength="150" name="description" style="height: 135px; resize:none;">{{$ClassInfo->class_description}}</textarea>
                        <label class="ms-3" for="floatingDescription">Description</label>
                    </div>
                    <div class="mt-5 col-12 text-center">
                        <button type="submit" name="action" value="delete" class="btn btn-danger" style="font-size:18px;width:150px;" id="modalButtonType">Delete</button>
                        <button type="submit" name="action" value="submit" class="btn btn-primary" style="font-size:18px;width:150px;" id="modalButtonType">Update</button>
                    </div>
      
                </form>
            </div>
        </div>
    </div>
</div>
<div class="p-3 mt-5 mb-5 mx-5 bg-secondary text-white my-auto text-center h3">
        Course List
</div>

<div class="px-5 mx-0 mx-sm-5">
    <table id="editable" class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Course Name</th>
                <th>Description</th>
                <th style="width:1%;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($CourseInfo as $course)
            <tr>
                <td>{{($course->doc_order+1)}}</td>
                <td>{{$course->name}}</td>
                <td>{{$course->info}}</td>
                <td><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-name="{{$course->name}}" data-bs-info="{{$course->info}}" data-bs-path="{{ url('storage/courseVideo/'.$course->doc_path) }}" data-bs-whatever="@editCourseModal" data-bs-courseId="{{$course->id}}"><i class="bi bi-pencil-square"></i></button></td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">
                    <button class="row mx-auto border-1 m-auto" id="newCourse" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@newCourseModal" data-bs-classId="{{$ClassInfo->class_id}}">
                        <i class="bi bi-plus-circle-fill"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="updateForm" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-5 px-3">
            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
            Course Name:
            </label>
            <div class="col-8 mx-auto"><input type="text" class="form-control w-100" id="modalCourseName" name="courseNameModal"></div>
        </div>
        <div class="row mb-5 px-3">
            <label class="form-check-label col-4" for="flexCheckDefault">
            Description:
            </label>
            <div class="col-8 mx-auto"><textarea name="courseInfoModal" maxlength="150" id="modalCourseInfo" class="form-control" rows="5" style="resize:none;" placeholder="Enter your review here.."></textarea></div>
        </div>
        <div class="row px-3 mb-3">
            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
            Video:
            </label>
            <div id="modalCourseVideoVisible" class="col-8 my-auto">
                
            </div>
            <div class="col-8 mt-2 ms-auto">
                <input type="file" accept="video/*" class="form-control" name="courseVideoModal">
            </div>
        </div>
        <input style="display:none" name="class_id" value="{{$ClassInfo->class_id}}">
        <input style="display:none" name="nextOrder" value="{{count($CourseInfo)}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
        <button type="submit" name="action" value="delete" class="btn btn-danger" id="modalBtnDelete" data-bs-dismiss="modal">Delete</button>
        <button type="submit" name="action" value="submit" class="btn btn-primary" id="modalButtonType">Create</button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
    var exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')
        var classId = button.getAttribute('data-bs-classId')
        var courseId = button.getAttribute('data-bs-courseId')
        var name = button.getAttribute('data-bs-name')
        var info = button.getAttribute('data-bs-info')
        var path = button.getAttribute('data-bs-path')
        var modalTitle = exampleModal.querySelector('.modal-title')
        var modalCourseName = exampleModal.querySelector('#modalCourseName')
        var modalCourseInfo = exampleModal.querySelector('#modalCourseInfo')
        var modalButtonType = exampleModal.querySelector('#modalButtonType')
        var modalBtnDelete = exampleModal.querySelector('#modalBtnDelete')
        var modalCourseVideoVisible = exampleModal.querySelector('#modalCourseVideoVisible')
        var updateForm = exampleModal.querySelector('#updateForm')
        if(recipient=='@editCourseModal'){
            modalTitle.textContent = "Edit Class"
            modalCourseName.value = name
            modalCourseInfo.value = info
            modalButtonType.innerHTML = "Update"
            modalButtonType.setAttribute('value','submit')
            updateForm.setAttribute('action','/updateCourseInfo/'+courseId)
            modalCourseVideoVisible.style.display = 'inline'
            modalBtnDelete.style.display = 'inline'
            modalCourseVideoVisible.innerHTML = "<video controls disablePictureInPicture controlsList='nodownload' class='card-img-top w-100'><source src='"+path+"' type='video/mp4'>Your browser does not support the video tag.</video>"
        }else if(recipient=="@newCourseModal"){
            modalTitle.textContent = "New Class"
            modalCourseName.value = ""
            modalCourseInfo.value = ""
            modalButtonType.innerHTML = "Create"
            modalButtonType.setAttribute('value','create')
            updateForm.setAttribute('action','/updateCourseInfo/'+classId)
            modalBtnDelete.style.display = 'none'
            modalCourseVideoVisible.style.display = 'none'
        }
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
    })
    exampleModal.addEventListener('hidden.bs.modal', function (event) {
        modalCourseVideoVisible.innerHTML = ''
    })

    document.getElementById('classThumbnail').onchange = evt => {
        const [file] = document.getElementById('classThumbnail').files;
        if (file) {
             document.getElementById('imgThumbnail').src = URL.createObjectURL(file);
        }
    }

    setInputFilter(document.getElementById("inputNumber"), function(value) {
        return /^-?\d*[.]?\d{0,2}$/.test(value); 
    });

</script>
@include('footer')