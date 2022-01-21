<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('storage/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <title>{{$Title}}</title>
</head>
<body>
<header class="p-3 mb-3 border-bottom">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      @isset($LoggedUserInfo)
        @if (($LoggedUserInfo->userType) == 'Student')
        <a href="{{route('studentMain')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-4 text-dark text-decoration-none ">
          <span class="fs-4"><i class="bi bi-cart"></i>Stemdemy</span>
        </a>
        @elseif(($LoggedUserInfo->userType) == 'Teacher')
        <a href="{{route('teacherMain')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-4 text-dark text-decoration-none ">
          <span class="fs-4"><i class="bi bi-cart"></i>Stemdemy</span>
        </a>
        @endif
      @else
      <a href="{{route('homePage')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-4 text-dark text-decoration-none ">
        <span class="fs-4"><i class="bi bi-cart"></i>Stemdemy</span>
      </a>
      @endisset

      <ul class="nav col-12 col-lg-5 me-lg-0 mb-2 justify-content-center mb-md-0">
        <li><button id="search_category" value="1" class="btn nav-link px-2 link-dark">Science</button></li>
        <li><button id="search_category" value="2" class="btn nav-link px-2 link-dark">Technology</button></li>
        <li><button id="search_category" value="3" class="btn nav-link px-2 link-dark">Engineering</button></li>
        <li><button id="search_category" value="4" class="btn nav-link px-2 link-dark">Mathematics</button></li>
      </ul>

      <form id="form" enctype="multipart/form-data" action="{{ route('searchPage')}}" method="post" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" >
      @csrf
        <div class="input-group">
          <input type="search" class="form-control rounded" name="keyterm" placeholder="Search" aria-label="Search"
          aria-describedby="search-addon" />
          <input style="display:none" name="nav_category" value="">
          <button type="submit" id="nav_search_btn" class="btn btn-primary">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
      @isset($LoggedUserInfo)
        @if(session()->has('LoggedUser'))
          @if (($LoggedUserInfo->userType) == 'Student')
            <button class="position-relative btn btn-outline-secondary col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 dropdown-toggle" id="dropdownCart" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-cart"></i> Cart
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              {{count($StudentCartInfo)}}
              </span>
            </button>
            
            <ul class="dropdown-menu text-small" aria-labelledby="dropdownCart">
              @if(count($StudentCartInfo)>0)
              @foreach($StudentCartInfo as $cart)
              <li>
                <div onclick="window.location='{{route('ClassPage',['id'=>$cart->class_id])}}'" class="dropdown-item">{{$cart->name}}
                  <a href="{{route('addCart',['classId'=>$cart->class_id,'userId'=>$LoggedUserInfo->id,'type'=>'2'])}}" style="height:25px;" class="float-end btn btn-sm btn-outline-danger">
                    <i class="bi bi-x-lg" style="align-items:center;display: flex;"></i>
                  </a>
                </div>
              </li>
              @endforeach
              @endif
              <li><hr class="dropdown-divider"></li>
              <li><button onclick="window.location='{{route('cartPage')}}'" class="btn btn-outline-success mx-5">View Cart</button></li>
            </ul>
          @else
            <div class="offset-1"></div>
          @endif
          <div class="dropdown text-end">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="{{ url('storage/profilePic/'.$LoggedUserInfo->profile_pic_path) }}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/1946/1946429.png'" alt="profile_pic" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser">
              <li><a class="dropdown-item" href="{{route('personalInfoPage')}}">User Profile</a></li>
              @if (($LoggedUserInfo->userType) == 'Student')
              <li><a class="dropdown-item" href="{{route('myClassPage',['Type'=>'myFav'])}}">My Favorite</a></li>
              <li><a class="dropdown-item" href="{{route('myClassPage',['Type'=>'myClass'])}}">My Class</a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>
            </ul>
          </div>
        @endif
      @endisset

    </div>
  </div>
</header>