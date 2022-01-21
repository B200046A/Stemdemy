<div class="col">
    <div class="position-relative">
        @isset($Type)
            @if (($Type) == 'Student')
            @isset($Fav)
            <button onclick="window.location='{{route('addFav',['classId'=>$ClassId,'userId'=>$UserId,'type'=>'2'])}}'" id="fav" class="btn btn-danger mb-3" data-toggle="tooltip" data-placement="bottom" title="Remove from favorite list">
                <i class="bi bi-trash"></i>
            </button>
            @else
            <button onclick="window.location='{{route('addFav',['classId'=>$ClassId,'userId'=>$UserId,'type'=>'1'])}}'" id="fav" class="btn btn-danger mb-3" data-toggle="tooltip" data-placement="bottom" title="Add to favorite list">
                <i class="bi bi-suit-heart-fill"></i>
            </button>
            @endisset
            @elseif(($Type)=='Teacher')
                <a onclick="window.location='{{route('teacher_del_class',['classId'=>$ClassId])}}'" id="fav" class="btn btn-secondary mb-3">
                    <i class="bi bi-trash"></i>
                </a>
            @endif
        @endisset
        <div class="card" style="padding-bottom:40px;">
            @isset($Thumbnail)
                <img src="{{ url('storage/classThumbnail/'.$Thumbnail) }}" onerror="this.onerror=null; this.src='{{url('storage/classThumbnail/image-not-found.png')}}'" class="card-img-top" alt="..." width="auto" height="300px;">
            @else
                <img src="{{url('storage/classThumbnail/image-not-found.png')}}" class="card-img-top" alt="..." width="auto" height="300px;">
            @endisset
            <div class="card-body">
                <h5 class="card-title">{{$ClassName}}</h5>
                <p class="card-text fw-bold">Category: {{$Category}} </p>
                <p class="card-text">Price: {{$Price}} </p>
                <p class="card-text mb-3">Rating: 
                @isset($Rating)
                    {{$Rating}}
                @else
                    None
                @endisset
                </p>
                @isset($updated)
                    <p class="card-text"><small class="text-muted">{{$updated}}</small></p>
                @endisset
                <a href="{{route('ClassPage',['id'=>$ClassId])}}" class="stretched-link"></a>
            </div>
        </div>
        @isset($Type)
            @if (($Type) == 'Student')
                @if(($owned)=='true')
                    <button id="btnCard" class="btn btn-success mb-3 w-75" style="left: 12.5%;" disabled>
                        <i class="bi-check2-circle"></i>
                        Owned
                    </button>
                @else
                    @isset($Cart)
                        <button onclick="window.location='{{route('addCart',['classId'=>$ClassId,'userId'=>$UserId,'type'=>'2'])}}'" id="btnCard" class="btn btn-danger mb-3 w-75" style="left: 12.5%;">
                            <i class="bi bi-bag-x-fill"></i>
                            Delete from Cart
                        </button>
                        @else
                        <button onclick="window.location='{{route('addCart',['classId'=>$ClassId,'userId'=>$UserId,'type'=>'1'])}}'" id="btnCard" class="btn btn-outline-danger mb-3 w-75" style="left: 12.5%;">
                            <i class="bi bi-bag-plus"></i>
                            Add to Cart
                        </button>
                    @endisset
                @endif
            @elseif(($Type)=='Teacher')
                <button onclick="window.location='{{ url('teacher/editClassPage/'.$ClassId)}}'" id="btnCard" class="btn btn-outline-danger mb-3 w-75" style="left: 12.5%;">
                    <i class="bi bi-pencil-square"></i>
                    Edit
                </button>
            @endif
        @endisset
    </div>
</div>