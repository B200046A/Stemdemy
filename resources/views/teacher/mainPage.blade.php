@include('header',['Title'=>"Teacher Main Page"])
<div class="py-3"></div>
<div class="p-3 mt-5 mb-2 mx-5 bg-secondary text-white my-auto text-center h3">
        My created class
</div>
<div class="container mt-4 pb-5">
    @if (session('status'))
        <h6 class="alert alert-success" id="status">{{ session('status') }}</h6>
    @endif
    @if (session('danger'))
        <h6 class="alert alert-danger" id="status">{{ session('danger') }}</h6>
    @endif
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
        @foreach($ClassInfo as $class)
            @php
            $data = array();
            $data+=array('UserId'=> "$LoggedUserInfo->id");
            $data+=array('ClassId'=> "$class->class_id");
            $data+=array('ClassName'=> "$class->class_name");
            $data+=array('Category'=> "$class->category_name");
            $data+=array('Price'=> "$class->price");
            $data+=array('Type'=> "$LoggedUserInfo->userType");
            $data+=array('updated'=> "$class->class_update");
            if(isset($RatingInfo[$loop->index]->ratings_average)){
                $data+=array('Rating'=> $RatingInfo[$loop->index]->ratings_average);
            }
            if(isset($class->class_thumbnail)){
                $data+=array('Thumbnail'=> "$class->class_thumbnail");
            }
            @endphp
            @include('classCard',$data)
        @endforeach
        <div class="col text-center">
            <button onclick="window.location='{{ url('teacher/createClassPage/')}}'" class="col btn btn-outline-secondary h-100 w-100">
                <i class="bi bi-plus-square" style="font-size: 10vw;"></i><br>
                <span class="fs-4">New Class</span>
            </button>
        </div>
    </div>
</div>
@include('footer')