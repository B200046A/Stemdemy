@include('header',['Title'=>"Stemdemy - Class Page"])
<!-- default styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

<!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme CSS files as mentioned below (and change the theme property of the plugin) -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />

<!-- important mandatory libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/star-rating.min.js" type="text/javascript"></script>

<!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme JS files as mentioned below (and change the theme property of the plugin) -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.js"></script>

<!-- optionally if you need translation for your language then include locale file as mentioned below (replace LANG.js with your own locale file) -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/locales/LANG.js"></script>
<nav class="col offset-1 my-5 ps-2" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            @isset($LoggedUserInfo)
            @if (($LoggedUserInfo->userType) == 'Student')
                <a href="{{route('studentMain')}}">
            @elseif(($LoggedUserInfo->userType)=='Teacher')
                <a href="{{route('teacherMain')}}">
            @endif
            @else
                <a href="{{route('homePage')}}">
            @endisset
        
        Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$ClassInfo->class_name}}</li>
    </ol>
</nav>
<div class="card border border-5 col-10 container p-sm-4 p-0" style="border-radius: 1rem;">
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
    <div class="row card-body gx-5 row-cols-3 px-auto">
        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
            <label class="fs-3 mb-3">{{$ClassInfo->class_name}}</label>
            <div class="form-floating">
                <textarea class="form-control" name="description" style="height: 200px; resize:none;" disabled>
                    {{$ClassInfo->class_info}}
                </textarea>
            </div>
        </div>
        <div class="col-sm-6 col-12 mb-sm-0 mb-4 text-center">
            <div class="border">
                @isset($ClassInfo->class_thumbnail)
                    <img src="{{ url('storage/classThumbnail/'.$ClassInfo->class_thumbnail) }}" onerror="this.onerror=null; this.src='{{url('storage/classThumbnail/image-not-found.png')}}'" class="card-img-top text-center" alt="..." style="max-height:300px; max-width:100%; width:auto; height:auto;">
                @else
                    <img src="{{url('storage/classThumbnail/image-not-found.png')}}" class="card-img-top" alt="..." style="max-height:300px; max-width:100%; width:auto; height:auto;">
                @endisset
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="row g-2">
                <div class="col-6 text-end">
                    <label class="fs-5 me-3">Number of Students:</label>
                </div>
                <div class="col-6">
                    <label class="fs-5 me-3">{{$JoinedStudentNum}}</label>
                </div>
                <div class="col-6 text-end">
                    <label class="fs-5 me-3">Price:</label>
                </div>
                <div class="col-6">
                    <label class="fs-5 me-3">${{$ClassInfo->price}}</label>
                </div>
                <div class="col-6 text-end">
                    <label class="fs-5 me-3">Average Rating:</label>
                </div>
                <div class="col-6">
                    <label class="fs-5 me-3">
                        @isset($RatingInfo)
                        {{$RatingInfo->ratings_average}}
                        @else
                        Undefined
                        @endisset
                    </label>
                </div>
                <div class="col-6 text-end">
                    <label class="fs-5 me-3">Created At:</label>
                </div>
                <div class="col-6">
                    <label class="fs-5 me-3">{{$ClassInfo->class_created}}</label>
                </div>
                <div class="col-6 text-end">
                    <label class="fs-5 me-3">Last Updated:</label>
                </div>
                <div class="col-6">
                    <label class="fs-5 me-3">{{$ClassInfo->class_update}}</label>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-12 px-5 my-auto mb-3">
            <div class="row gx-3">
                @isset($LoggedUserInfo)
                    @if(($LoggedUserInfo->userType)=="Student")
                        {{-- @if($BtnRatingInfo=='[]')
                        <div class="col-sm-4 col-12">
                        @else
                        <div class="col-sm-6 col-12">
                        @endif --}}
                        <div class="col">
                            @if($FavClassInfo=='[]')
                            <button onclick="window.location='{{route('addFav',['classId'=>$ClassInfo->class_id,'userId'=>$LoggedUserInfo->id,'type'=>'1'])}}'" class="btn btn-outline-danger h-75 w-100 mt-3">
                                <i class="bi bi-heart"></i>
                                Add to Favorite
                            </button>
                            @else
                            <button onclick="window.location='{{route('addFav',['classId'=>$ClassInfo->class_id,'userId'=>$LoggedUserInfo->id,'type'=>'2'])}}'" class="btn btn-danger h-75 w-100 mt-3" >
                                <i class="bi bi-heart"></i>
                                Remove From Favorite
                            </button>
                            @endif
                        </div>
                        {{-- @if($BtnRatingInfo=='[]')
                        <div class="col-sm-4 col-12">
                        @else
                        <div class="col-sm-6 col-12">
                        @endif --}}
                        @if(count($ClassStudentInfo)==0)
                            @if($CartInfo=='[]')
                            <div class="col">
                            <button onclick="window.location='{{route('addCart',['classId'=>$ClassInfo->class_id,'userId'=>$LoggedUserInfo->id,'type'=>'1'])}}'" class="btn btn-outline-success h-75 w-100 mt-3">
                                <i class="bi-bag-plus"></i>
                                Add to Cart List
                            </button>
                            </div>
                            @else
                            <div class="col">
                            <button onclick="window.location='{{route('addCart',['classId'=>$ClassInfo->class_id,'userId'=>$LoggedUserInfo->id,'type'=>'2'])}}'" class="btn btn-success h-75 w-100 mt-3" >
                                <i class="bi-bag-plus"></i>
                                Remove From Cart List
                            </button>
                            </div>
                            @endif
                        @endif
                        </div>
                        @if($BtnRatingInfo=='[]')
                            <div class="col">
                                <button type="button" class="btn btn-outline-warning h-75 w-100 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="bi bi-star"></i>
                                    Write a review
                                </button>
                            </div>
                        @endif
                    @elseif(($LoggedUserInfo->userType)=="Teacher")
                        @if($TeacherOwnedClassInfo!='[]')
                            <div class="col-sm-6 col-12">
                                <a href="{{ url('teacher/editClassPage/'.$ClassInfo->class_id)}}" class="btn btn-primary h-75 w-100 mt-3" >
                                    <i class="bi bi-pen"></i>
                                    Edit
                                </a>
                            </div>
                            <div class="col-sm-6 col-12">
                                <a href="{{route('teacher_del_class',['classId'=>$ClassInfo->class_id])}}" class="btn btn-danger h-75 w-100 mt-3 confirmation deleteClass">
                                    <i class="bi bi-trash"></i>
                                    Delete
                                </a>
                            </div>
                        @endif
                    @endif
                @endisset
            </div>
        </div>
    </div>
</div>
@if(count($CourseInfo)>0)
<label class="offset-2 fs-2 mt-5 mb-3" onselectstart="return false">Class Content</label>
<div class="list-group list-group-flush px-5 col-sm-8 col-11 container mb-5">
    @foreach($CourseInfo as $course)
        <a href="{{route('CoursePage',['id'=>$course->id])}}" class="list-group-item list-group-item-secondary list-group-item-action ps-4 link-primary">
            {{$course->name}}
        </a>
    @endforeach
</div>
@else
<div class="mt-5 mb-3"></div>
@endif

<div class="col-sm-7 col-10 pb-4 mx-auto border border-3">
    <label class="offset-1 fs-3 mt-4 mb-3" onselectstart="return false">Teacher Info</label>
    <div class="row">
        <div class="offset-1 col-sm-3 col-12 px-sm-0 px-5 mb-sm-0 mb-3 mx-auto">
            <div class="col-12 border border-dark">
                <img src="../storage/profilePic/{{$TeacherInfo->profile_pic_path}}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/1946/1946429.png'" class="card-img-top text-center" alt="...">
            </div>
            <div class="col-12 mt-2 text-center">
                <span class="fs-5">{{$TeacherInfo->username}}</span>
            </div>
        </div>
        <div class="col-sm-8 col-12 row">
            <div class="col-5 mb-sm-0 mb-3 my-sm-auto text-end">
                <label class="fs-5 me-3">Email:</label>
            </div>
            <div class="col-7 mb-sm-0 mb-3 my-sm-auto">
                <label class="fs-5 me-3">{{$TeacherInfo->email}}</label>
            </div>
            <div class="col-5 mb-sm-0 mb-3 my-sm-auto text-end">
                <label class="fs-5 me-3">Contact No:</label>
            </div>
            <div class="col-7 mb-sm-0 mb-3 my-sm-auto">
                <label class="fs-5 me-3">{{$TeacherInfo->contact_number}}</label>
            </div>
            <div class="col-5 mb-sm-0 mb-3 my-sm-auto text-end">
                <label class="fs-5 me-3">Average Rating:</label>
            </div>
            <div class="col-7 mb-sm-0 mb-3 my-sm-auto">
                <label class="fs-5 me-3">{{round($TeacherRatingInfo,2)}}</label>
            </div>
            <div class="col-5 mb-sm-0 my-sm-auto text-end">
                <label class="fs-5 me-3">Owned Students:</label>
            </div>
            <div class="col-7 mb-sm-0 my-sm-auto">
                <label class="fs-5 me-3">{{$StudentNumInfo}}</label>
            </div>
        </div>
    </div>
</div>
<div class="accordion-item col-sm-7 col-10 mb-5 mx-auto" style="border-width:3px;">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        <span class="fs-5 ms-2">Introduction</span>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">{{$TeacherInfo->introduction}}</div>
    </div>
</div>

@isset($LoggedUserInfo)
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" enctype="multipart/form-data" action="{{ route('addRating')}}" method="post">
    @csrf
    @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rating for the course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-12 text-center"><input id="inputStar" name="star" type="text" class="rating" data-size="lg"></div>
        <div class="col-12 mt-2 px-1">
            <div class="form-group">
                <textarea name="txtreview" maxlength="150" class="form-control" rows="5" style="resize:none;" placeholder="Enter your review here.."></textarea>
            </div>
        </div>
      </div>
      <input style="display:none" name="class_id" value="{{$ClassInfo->class_id}}">
      <input style="display:none" name="user_id" value="{{$LoggedUserInfo->id}}">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>
@endisset

@isset($LoggedUserInfo)
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" name="replyForm" onsubmit="return replyFormSubmit();" enctype="multipart/form-data" action="{{ route('replyComment')}}" method="post">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Reply to <span id="replyTarget"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="col-12 mt-2 px-1">
                <div class="form-group">
                    <span id="errorTxtReply" style="color:red;"></span>
                    <textarea name="txtreply" maxlength="150" class="form-control" rows="5" style="resize:none;" placeholder="Enter your comment here.."></textarea>
                </div>
            </div>
        </div>
        <input style="display:none" id="replyId" name="reply_id">
        <input style="display:none" name="class_id" value="{{$ClassInfo->class_id}}">
        <input style="display:none" name="user_id" value="{{$LoggedUserInfo->id}}">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Reply</button>
        </div>
        </form>
    </div>
</div>
@endisset

<div class="col-sm-9 col-10 pb-4 mx-auto border">
    @isset($LoggedUserInfo)
        <label class="offset-1 fs-3 mt-5 mb-3" onselectstart="return false">Comment</label>
        <form enctype="multipart/form-data" action="{{ route('submitComment')}}" method="post">
            @csrf
            @method('PUT')
            <div class="col-12 px-5">
                <div class="form-group">
                    <textarea name="txtcomment" class="form-control" rows="5" style="resize:none; overflow-y: scroll;" placeholder="Enter your comment here.."></textarea>
                </div><!--ends from group-->
            </div>
            <input style="display:none" name="class_id" value="{{$ClassInfo->class_id}}">
            <input style="display:none" name="user_id" value="{{$LoggedUserInfo->id}}">
            <div class="offset-sm-9 offset-4 col-sm-2 col-4">
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </div>
        </form>
        <div class="col-12 border mt-5 "></div>
    @endisset
    @isset($LoggedUserInfo)
        @if(($LoggedUserInfo->userType)=="Teacher")
            @if($TeacherOwnedClassInfo!='[]')
            <label class="offset-1 fs-3 mt-5 mb-3 border-bottom border-warning" onselectstart="return false">{{count($ClassRatingInfo)}} Reviews</label>
            @foreach($ClassRatingInfo as $classrating)
                <div class="d-flex flex-start ms-4 mt-4">
                    <a class="ms-3 me-3" href="#">
                        <img
                        class="rounded-circle shadow-1-strong"
                        src="{{ url('storage/profilePic/'.$classrating->profile) }}" 
                        onerror="this.onerror=null; this.src='{{url('storage/classThumbnail/image-not-found.png')}}'"
                        alt="avatar"
                        width="65"
                        height="65"
                        />
                    </a>
                    <div class="row flex-grow-1 flex-shrink-1">
                        <div class="col-7">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-1">
                                {{$classrating->username}} <span class="small">- {{$classrating->review_at}}</span>
                                </p>
                            </div>
                            <p class="small mb-0">
                                {{$classrating->review}}
                            </p>
                        </div>
                        <div class="col-5">
                            <input id="starDisplay" name="star" type="text" class="rating" value="{{$classrating->rating_star}}" data-size="sm">
                        </div>
                    </div>
                </div>
            @endforeach
                <div class="col-12 border mt-5 "></div>
            @endif
        @endif
    @endisset
    
    <label class="offset-1 fs-3 mt-5 mb-3 border-bottom border-danger" onselectstart="return false">{{count($SubCommentInfo)+count($CommentInfo)}} Comments</label>
    @foreach($CommentInfo as $comment)
        <div class="d-flex flex-start ms-4 mt-4">
            <a class="ms-5 me-3" href="#">
                <img
                class="rounded-circle shadow-1-strong"
                src="{{ url('storage/profilePic/'.$comment->profile) }}" 
                onerror="this.onerror=null; this.src='{{url('storage/classThumbnail/image-not-found.png')}}'"
                alt="avatar"
                width="65"
                height="65"
                />
            </a>
            <div class="row flex-grow-1 flex-shrink-1">
                <div class="col-7">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-1">
                        {{$comment->username}} <span class="small">- {{$comment->comment_at}}</span>
                        </p>
                    </div>
                    <p class="small mb-0">
                        {{$comment->comment}}
                    </p>
                </div>
                <div class="col ms-3">
                    @isset($LoggedUserInfo)
                    <button type="button" class="btn btn-primary"><i class="bi bi-hand-thumbs-up"></i> Like</button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#replyModal" data-bs-replyTarget="{{$comment->username}}" data-bs-replyId="{{$comment->comment_id}}" data-bs-replyType="1"><i class="bi bi-reply"></i> Reply</button>
                        @if(($LoggedUserInfo->id)==($comment->user_id))
                        <a href="{{route('deleteComment',['commentId'=>$comment->comment_id])}}" class="btn btn-danger confirmation mainComment"><i class="bi bi-trash"></i></a>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        @php
        $commentID=$CommentInfo[$loop->index]->comment_id
        @endphp
        @foreach($SubCommentInfo as $subcomment)
            @if(($subcomment->sub_comment)==($commentID))
            <div class="col offset-1">
                <div class="d-flex flex-start ms-4 mt-4">
                    <a class="me-3" href="#">
                        <img
                        class="rounded-circle shadow-1-strong"
                        src="{{ url('storage/profilePic/'.$subcomment->profile) }}" 
                        onerror="this.onerror=null; this.src='{{url('storage/classThumbnail/image-not-found.png')}}'"
                        alt="avatar"
                        width="65"
                        height="65"
                        />
                    </a>
                    <div class="row flex-grow-1 flex-shrink-1">
                        <div class="col-7">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-1">
                                {{$subcomment->username}} <span class="small">- {{$subcomment->comment_at}}</span>
                                </p>
                            </div>
                            <p class="small mb-0">
                                {{$subcomment->comment}}
                            </p>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary"><i class="bi bi-hand-thumbs-up"></i> Like</button>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#replyModal" data-bs-replyTarget="{{$subcomment->username}}" data-bs-replyId="{{$comment->comment_id}}" data-bs-replyType="2"><i class="bi bi-reply"></i> Reply</button>
                            @if(($LoggedUserInfo->id)==($subcomment->user_id))
                            <a href="{{route('deleteComment',['commentId'=>$subcomment->comment_id])}}" class="btn btn-danger confirmation subComment"><i class="bi bi-trash"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
        @if($loop->last)
        @else
        <div class="col-11 border mt-4 mx-auto"></div>
        @endif
    @endforeach
    <div class="my-5"></div>
</div>

<script type="text/javascript">
    var exampleModal = document.getElementById('exampleModal');
    var replyModal = document.getElementById('replyModal');
    exampleModal.addEventListener('hidden.bs.modal', modalReset);
    replyModal.addEventListener('hidden.bs.modal', modalReset);
    replyModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var replyTarget = button.getAttribute('data-bs-replyTarget')
        var replyId = button.getAttribute('data-bs-replyId')
        var modalreplyTarget = replyModal.querySelector('#replyTarget')
        var modalreplyId = replyModal.querySelector('#replyId')
        modalreplyTarget.innerHTML = replyTarget
        modalreplyId.value = replyId
    });

    function modalReset(){
        $('#exampleModal form')[0].reset();
        $('#replyModal form')[0].reset();
        document.getElementById('errorTxtReply').innerHTML = '';
    }

    function replyFormSubmit(){
        if (document.replyForm.txtreply.value == ''){
            document.getElementById('errorTxtReply').innerHTML = 'The comment field is required';
            return false;
        }else{
            document.getElementById('errorTxtReply').innerHTML = '';
        }
    }

    $('.confirmation').on('click', function () {
        var msg="Are you sure to delete this ";
        if(this.classList.contains("mainComment")){
            msg+="comment? (Including the replied comments will be deleted)";
        }else if(this.classList.contains("subComment")){
            msg+="comment?";
        }else if(this.classList.contains("deleteClass")){
            msg+="class?";
        }
        var ok = confirm(msg);
        if(!ok){
            return false;
        }
    });

    $('[id^=starDisplay]').rating({displayOnly: true});

</script>
@include('footer')