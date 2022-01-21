@include('header',['Title'=>"Student - Search Page"])
<div class="card border border-5 col-10 container mb-5" style="border-radius: 1rem;">
    <form id="form" enctype="multipart/form-data" action="{{ route('searchPage')}}" method="post" class="row card-body gx-5 row-cols-3 px-auto">
    @csrf
        <div class="col-sm-3 col-12 mb-sm-0 mb-3">
            <label class="fs-5 mb-3" onselectstart="return false"><i class="bi bi-funnel-fill me-1" style="font-size: 20px; color: cornflowerblue;"></i>Filter</label><br>
            <div class="form-floating">
                <select class="form-select" name="sort" id="sortingSelection" aria-label="Floating label select example">
                    <option value="1" selected>Most Relevant</option>
                    <option value="2">Most Reviewed</option>
                    <option value="3">Highest Rated</option>
                    <option value="4">Newest</option>
                </select>
                <label for="floatingSelect">Sort</label>
            </div>
        </div>
        <div class="col-sm-3 col-12 mb-sm-0 mb-4 text-center">
            <div class="border py-3">
                <label class="fs-5 mb-3" onselectstart="return false">Category:</label><br>
                <input type="checkbox" class="btn-check" name="category[]" value="1" id="checkboxScience" autocomplete="off">
                <label class="btn btn-outline-primary mb-2" for="checkboxScience" style="width:80%;">Science</label><br>
                <input type="checkbox" class="btn-check" name="category[]" value="2" id="checkboxTechnology" autocomplete="off">
                <label class="btn btn-outline-primary mb-2" for="checkboxTechnology" style="width:80%;">Technology</label><br>
                <input type="checkbox" class="btn-check" name="category[]" value="3" id="checkboxEngineering" autocomplete="off">
                <label class="btn btn-outline-primary mb-2" for="checkboxEngineering" style="width:80%;">Engineering</label><br>
                <input type="checkbox" class="btn-check" name="category[]" value="4" id="checkboxMathematics" autocomplete="off">
                <label class="btn btn-outline-primary mb-2" for="checkboxMathematics" style="width:80%;">Mathematics</label><br>
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="row g-2">
                <div class="col-12 my-4">
                    <div class="input-group">
                        <label class="fs-5 me-3" onselectstart="return false">Price Range:</label>
                        <input type="text" aria-label="Min Price" name="minPrice" class="form-control" placeholder="Min">
                        <span class="mx-2 my-auto">-</span>
                        <input type="text" aria-label="Max Price" name="maxPrice" class="form-control" placeholder="Max">
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="text-center">
                        <label class="fs-5 me-3" onselectstart="return false">Rating:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="radioRating1" value="4.5">
                            <label class="form-check-label" for="radioRating1">>4.5</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="radioRating2" value="4">
                            <label class="form-check-label" for="radioRating2">>4.0</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="radioRating3" value="3.5">
                            <label class="form-check-label" for="radioRating3">>3.5</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="radioRating4" value="3">
                            <label class="form-check-label" for="radioRating4">>3.0</label>
                        </div>
                        <button type="button" id="btnClearRatingRadio" class="btn btn-light border px-3"><i class="bi bi-x-lg"></i>Reset</button>
                    </div>
                </div>
                <input style="display:none" name="page" value="{{$page}}">
                <input style="display:none" name="direct_search" value="yes">
                <div class="col-12">
                    <div class="px-sm-3 px-0 mx-auto">
                        <div class="input-group">
                            <input type="search" class="form-control rounded" name="keyterm" placeholder="Search courses.." aria-label="Search"
                            aria-describedby="search-addon" />
                            <button type="submit" id="btnSearch" class="btn btn-primary mt-3" style="width:100%;">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container mt-4 mb-5">
    <div class="row row-cols-1 row-cols-lg-4 g-3">
        @foreach($ClassInfo as $class)
            @php
            $data = array();
            if($LoggedUserInfo!=''){
                $data+=array('UserId'=> "$LoggedUserInfo->id");
                $data+=array('Type'=> "$LoggedUserInfo->userType");
            }
            $data+=array('ClassId'=> "$class->class_id");
            $data+=array('ClassName'=> "$class->class_name");
            $data+=array('Category'=> "$class->category_name");
            $data+=array('Price'=> "$class->price");
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
</div>

<div>
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item me-3">
        @if($page==1)
        <button class="page-link btn disabled">
        @else
        <button class="page-link" id="page" value="previous">
        @endif
        Previous</button></li>
        @if($page>2)
        <li class="page-item active" aria-current="page"><button class="page-link" id="page" value="{{$page-2}}">{{$page-2}}</button></li>
        <li class="page-item active" aria-current="page"><button class="page-link" id="page" value="{{$page-1}}">{{$page-1}}</button></li>
        @elseif($page==2)
        <li class="page-item active" aria-current="page"><button class="page-link" id="page" value="{{$page-1}}">{{$page-1}}</button></li>
        @endif
        <li class="page-item active" aria-current="page"><button class="page-link btn disabled" id="page" value="{{$page}}">{{$page}}</button></li>
        @if(($lastPage-$page)>2)
        <li class="page-item active" aria-current="page"><button class="page-link" id="page" value="{{$page+1}}">{{$page+1}}</button></li>
        <li class="page-item active" aria-current="page"><button class="page-link" id="page" value="{{$page+2}}">{{$page+2}}</button></li>
        @elseif(($lastPage-$page)==2)
        <li class="page-item active" aria-current="page"><button class="page-link" id="page" value="{{$page+1}}">{{$page+1}}</button></li>
        @endif
        @if($lastPage!=$page)
        <li class="page-item disabled"><a class="page-link">..</a></li>
        <li class="page-item active" aria-current="page"><button class="page-link btn" id="page" value="{{$lastPage}}">{{$lastPage}}</button></li>
        <li class="page-item ms-3"><button class="page-link" id="page" value="next">Next</button></li>
        @else
        <li class="page-item ms-3"><button class="page-link btn disabled">Next</button></li>
        @endif
    </ul>
    </nav>
</div>
<script type="text/javascript">
    var searchFill=@json($searchSelection);
    console.log(searchFill);
    if(searchFill['sort']!=null){
        document.getElementById("sortingSelection").value = searchFill['sort'];
    }
    if(searchFill['category']!=null){
        searchFill['category'].forEach(function(element){
            if(element==1){
                document.getElementById("checkboxScience").checked = true;
            }else if(element==2){
                document.getElementById("checkboxTechnology").checked = true;
            }else if(element==3){
                document.getElementById("checkboxEngineering").checked = true;
            }else if(element==4){
                document.getElementById("checkboxMathematics").checked = true;
            }
        });
    }
    if(searchFill['minPrice']!=null){
        document.getElementsByName("minPrice")[0].value = searchFill['minPrice'];
    }
    if(searchFill['maxPrice']!=null){
        document.getElementsByName("maxPrice")[0].value = searchFill['maxPrice'];
    }
    if(searchFill['rating']!=null){
        if(searchFill['rating']=='4.5'){
            document.getElementById("radioRating1").checked = true;
        }else if(searchFill['rating']=='4'){
            document.getElementById("radioRating2").checked = true;
        }else if(searchFill['rating']=='3.5'){
            document.getElementById("radioRating3").checked = true;
        }else if(searchFill['rating']=='3'){
            document.getElementById("radioRating4").checked = true;
        }
    }
    if(searchFill['keyterm']!=null){
        document.getElementsByName("keyterm")[1].value = searchFill['keyterm'];
    }
    $('#btnClearRatingRadio').on('click', function(){
        $('input[name="rating"]').prop('checked', false);
    });

    $('button[id="page"]').on('click', function(){
        $("[name='direct_search']").val('false');
        if(this.value=='next'){
            $("[name='page']").val({{$page}}+1);
        }else if(this.value=='previous'){
            $("[name='page']").val({{$page}}-1);
        }else{
            $("[name='page']").val(this.value);
        }
        jQuery("#btnSearch").trigger('click');
        return false;
    });
</script>
@include('footer')