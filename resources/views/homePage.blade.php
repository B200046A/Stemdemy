@include('header',['Title'=>"Home Page"])
<main>
    <div class="mb-sm-2 p-sm-5 p-4">
        <div class="ps-sm-5 pe-sm-5 ms-sm-5 me-sm-5">
            <div class="card">
                <div class="card-body m-2">
                    <h5 class="card-title fs-1">Stemdemy</h5>
                    <p class="card-text pb-2 blockquote">Whether you want to learn or to share what you know,
                        <br> you’ve come to the right place. As a global destination
                        <br> for online learning, we connect people through knowledge.</p>
                    <a href="{{route('login')}}" class="btn btn-primary ms-3">Getting Started Today</a>
                </div>
            </div>
        </div>
    </div>

    <div class="p-3 mb-2 ms-5 me-5 bg-secondary text-white my-auto text-center h3">
            The popular classes
    </div>

    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-lg-4 g-3">
            @foreach($PopularClassInfo as $class)
                @php
                $data = array();
                $data+=array('ClassId'=> "$class->class_id");
                $data+=array('ClassName'=> "$class->class_name");
                $data+=array('Category'=> "$class->category_name");
                $data+=array('Price'=> "$class->price");
                $data+=array('updated'=> "$class->class_update");
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
        </div>
        <button type="button" id="view_more" class="btn btn-outline-secondary offset-10 my-3"><i class="bi bi-chevron-double-right"></i>View More
        </button>
    </div>
</main>
<script>
    $('button[id="view_more"]').on('click', function(){
      jQuery("#nav_search_btn").trigger('click');
      return false;
    });
</script>
@include('footer')