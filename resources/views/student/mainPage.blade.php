@include('header',['Title'=>"Main Page - $LoggedUserInfo->username"])
<div class="container mb-3">
    @if (session('status'))
        <h6 class="alert alert-success" id="status">{{ session('status') }}</h6>
    @endif
    @if (session('danger'))
        <h6 class="alert alert-danger" id="status">{{ session('danger') }}</h6>
    @endif
</div>
<div class="col-sm-6 col-3 mb-2 mx-auto">
    <label class="h1" onselectstart="return false">Categories</label>
</div>
<div class="card border border-5 col-lg-8 col-12 container mb-5" style="border-radius: 1rem;">
    <div class="row card-body g-3 row-cols-4  px-auto">
        <div class="col">
            <button id="search_category" value="1" class="btn btn-outline-secondary" style="width:100%;">
                <i class="bi bi-lightbulb" style="font-size: 40px; color: cornflowerblue;"></i>
                <br>Science
            </button>
        </div>
        <div class="col">
            <button id="search_category" value="2" class="btn btn-outline-secondary" style="width:100%;">
                <i class="bi bi-gear-fill" style="font-size: 40px; color: cornflowerblue;"></i>
                <br>Technology
            </button>
        </div>
        <div class="col">
            <button id="search_category" value="3" class="btn btn-outline-secondary" style="width:100%;">
                <i class="bi bi-tools" style="font-size: 40px; color: cornflowerblue;"></i>
                <br>Engineering
            </button>
        </div>
        <div class="col">
            <button id="search_category" value="4" class="btn btn-outline-secondary" style="width:100%;">
                <i class="bi bi-calculator-fill" style="font-size: 40px; color: cornflowerblue;"></i>
                <br>Mathematics
            </button>
        </div>
    </div>
</div>

<div class="p-3 mb-2 ms-5 mx-5 bg-secondary text-white my-auto text-center h3">
        My joined classes
</div>

<div class="container mt-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
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
            @isset($FavStatusInfo)
                @foreach($FavStatusInfo as $fav)
                    @php
                    if(($class->class_id)==($fav->class_id)){
                        $data+=array('Fav'=> 'true');
                    }
                    @endphp
                @endforeach
            @endisset
            @isset($CartStatusInfo)
                @foreach($CartStatusInfo as $cart)
                    @php
                    if(($class->class_id)==($cart->class_id)){
                        $data+=array('Cart'=> 'true');
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
    </div>
    @if($JoinedClassNum>=8)
        <a type="button" href="{{route('myClassPage',['Type'=>'myClass'])}}" class="btn btn-outline-secondary offset-10 my-3"><i class="bi bi-chevron-double-right"></i>View More
        </a>
    @else
    <div class="mb-5"></div>
    @endif
</div>

<div class="p-3 mb-2 ms-5 me-5 bg-secondary text-white my-auto text-center h3">
        The popular classes
</div>

<div class="container mt-4 mb-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
        @foreach($PopularClassInfo as $class)
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
            @isset($FavStatusInfo)
                @foreach($FavStatusInfo as $fav)
                    @php
                    if(($class->class_id)==($fav->class_id)){
                        $data+=array('Fav'=> 'true');
                    }
                    @endphp
                @endforeach
            @endisset
            @isset($CartStatusInfo)
                @foreach($CartStatusInfo as $cart)
                    @php
                    if(($class->class_id)==($cart->class_id)){
                        $data+=array('Cart'=> 'true');
                    }
                    @endphp
                @endforeach
            @endisset
            @isset($ClassStudentInfo)
                @foreach($ClassStudentInfo as $ownclass)
                    @php
                    if(($class->class_id)==($ownclass->id)){
                        $data['owned']= 'true';
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
    </div>
    <button type="button" id="view_more" class="btn btn-outline-secondary offset-10 my-3"><i class="bi bi-chevron-double-right"></i>View More
    </button>
</div>
<script>
    $('button[id="view_more"]').on('click', function(){
      jQuery("#nav_search_btn").trigger('click');
      return false;
    });
</script>
@include('footer')