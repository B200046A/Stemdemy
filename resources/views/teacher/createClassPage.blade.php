@include('header',['Title'=>"New Class Page"])

<nav class="col offset-1 my-5 ps-2" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('teacherMain')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">New Class</li>
    </ol>
</nav>
<div class="card border border-5 col-10 container p-sm-4 p-0" style="border-radius: 1rem;">
    <div class="row card-body gx-5 row-cols-1 px-auto">
        <div class="col-sm-12 col-12 mb-sm-0 mb-3">
            <label class="fs-3 mb-3">New Class</label>
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
                <form class="card-body p-5 row" id="updateForm" action="{{route('createNewClass')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3 col-12 col-lg-6">
                        <input type="text" class="form-control" name="className">
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
                        <img id="imgThumbnail" class="border" src="{{url('storage/classThumbnail/image-not-found.png')}}" style="width:100%; height:auto;">
                        @endisset
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="price" id="inputNumber">
                            <label class="ms-1" for="floatingInput">Class Price</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="classCategory" aria-label="Floating label select example">
                                @foreach ($CategoryInfo as $category)
                                <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Category</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" maxlength="150" name="description" style="height: 135px; resize:none;"></textarea>
                        <label class="ms-3" for="floatingDescription">Description</label>
                    </div>
                    <input style="display:none" name="user_id" value="{{$LoggedUserInfo->id}}">
                    <div class="mt-5 col-12 text-center">
                        <button type="submit" name="action" value="submit" class="btn btn-primary" style="font-size:18px;width:150px;" id="modalButtonType">Create</button>
                    </div>
      
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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