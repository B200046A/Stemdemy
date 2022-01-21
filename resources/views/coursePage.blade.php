@include('header',['Title'=>"$CurrentCourseInfo->class_name - $CurrentCourseInfo->name"])
<nav class="offset-2 col-10 mt-5" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
    @if (($LoggedUserInfo->userType) == 'Student')
        <a href="{{route('studentMain')}}">
    @elseif(($LoggedUserInfo->userType)=='Teacher')
        <a href="{{route('teacherMain')}}">
    @endif
    Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('ClassPage',['id'=>$CurrentCourseInfo->class_id])}}">{{$CurrentCourseInfo->class_name}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$CurrentCourseInfo->name}}</li>
  </ol>
</nav>
<div class="offset-2 col-10 ps-5 pt-3"><span class="fs-2 fw-lighter">{{$CurrentCourseInfo->class_name}}:</span><p class="fs-1 fw-bold">{{$CurrentCourseInfo->name}}</p></div>
<div class="col-10 border-2 border mx-auto my-5"></div>
<div class="container mt-1">
    <div class="row">
        <div class="col-12 col-sm-4">
            @foreach ($CourseInfo as $course)
            <div class="text-center">
                <p class="my-2"><a href="{{route('CoursePage',['id'=>$course->id])}}" class="text-info fs-5">
                    @if($course->name==$CurrentCourseInfo->name)
                    <span class="fw-bold">{{$course->name}}</span>
                    @else
                    {{$course->name}}
                    @endif
                </a></p>
                <div class="col-12 border mx-auto"></div>
            </div>
            @endforeach
        </div>
        <div class="col-12 col-sm-8">
            <div class="card border">
                <label class="col-12 ms-5 mt-4">Description: 
                    <p class="fs-3">{{$CurrentCourseInfo->info}}</p>
                </label>
                <div class="w-75 mb-5 mx-auto">
                    <video controls disablePictureInPicture controlsList='nodownload' class='card-img-top'>
                        <source src='{{ url('storage/courseVideo/'.$CurrentCourseInfo->doc_path) }}' type='video/mp4'>Your browser does not support the video tag.
                        </video>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')