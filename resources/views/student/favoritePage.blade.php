@include('header',['Title'=>$Title])
<nav class="col offset-1 my-5 ps-2" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="{{route('studentMain')}}">
        Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$Title}}</li>
    </ol>
</nav>
<div class="p-3 my-5 bg-secondary text-white text-center h3">
        {{$Title}}
</div>

<div class="container mt-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
        @if($Title=="My Class")
            @if (count($JoinedClassInfo)==0)
                <div class="my-5 py-5"></div>
            @endisset
            @foreach($JoinedClassInfo as $class)
                @php
                $data = array();
                $data+=array('UserId'=> "$LoggedUserInfo->id");
                $data+=array('ClassId'=> "$class->class_id");
                $data+=array('ClassName'=> "$class->class_name");
                $data+=array('Category'=> "$class->category_name");
                $data+=array('Price'=> "$class->price");
                $data+=array('Type'=> "$LoggedUserInfo->userType");
                $data+=array('updated'=> "$class->class_update");
                $data+=array('owned'=> 'true');
                @endphp
                @isset($RatingInfo)
                    @foreach($RatingInfo as $rating)
                        @php
                        if(($class->class_id)==($rating->class_id)){
                            $data+=array('Rating'=> $RatingInfo[$loop->index]->ratings_average);
                        }
                        @endphp
                    @endforeach
                @endisset
                @php
                if(isset($class->class_thumbnail)){
                    $data+=array('Thumbnail'=> "$class->class_thumbnail");
                }
                @endphp
                @include('classCard',$data)
            @endforeach
        @elseif($Title=="My Favorite")
            @if (count($FavClassInfo)==0)
                <div class="my-5 py-5"></div>
            @endisset
            @foreach($FavClassInfo as $class)
                @php
                $data = array();
                $data+=array('UserId'=> "$LoggedUserInfo->id");
                $data+=array('ClassId'=> "$class->class_id");
                $data+=array('ClassName'=> "$class->class_name");
                $data+=array('Category'=> "$class->category_name");
                $data+=array('Price'=> "$class->price");
                $data+=array('Type'=> "$LoggedUserInfo->userType");
                $data+=array('updated'=> "$class->class_update");
                $data+=array('owned'=> 'false');
                if(isset($RatingInfo[$loop->index]->ratings_average)){
                    $data+=array('Rating'=> $RatingInfo[$loop->index]->ratings_average);
                }
                if(isset($class->class_thumbnail)){
                    $data+=array('Thumbnail'=> "$class->class_thumbnail");
                }
                @endphp
                @isset($ClassStudentInfo)
                    @foreach($ClassStudentInfo as $ownclass)
                        @php
                        if(($class->class_id)==($ownclass->id)){
                            $data['owned']= 'true';
                        }
                        @endphp
                    @endforeach
                @endisset
                @include('classCard',$data)
            @endforeach
        @endif
    </div>
</div>

@include('footer')