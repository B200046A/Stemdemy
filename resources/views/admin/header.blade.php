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
        {{-- <a href="{{route('admin.index')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-4 text-dark text-decoration-none ">
            <span class="fs-4"><i class="bi bi-cart"></i>Stemdemy</span>
        </a> --}}
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-4 text-dark text-decoration-none col-3">
            <span class="fs-4"><i class="bi bi-app-indicator me-2"></i>Admin - Stemdemy</span>
        </a>
        @isset($LoggedUserInfo)
            <div class="dropdown text-end offset-7">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ url('storage/profilePic/'.$LoggedUserInfo->profile_pic_path) }}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/1946/1946429.png'" alt="profile_pic" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="{{route('admin_logout')}}">Sign out</a></li>
                </ul>
            </div>
        @endisset
    </div>
  </div>
</header>
@isset($LoggedUserInfo)
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('admin_index')}}">
                        <span data-feather="home"></span>
                        Dashboard
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">
                        <span data-feather="file"></span>
                        Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <span data-feather="shopping-cart"></span>
                        Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <span data-feather="users"></span>
                        Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <span data-feather="bar-chart-2"></span>
                        Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <span data-feather="layers"></span>
                        Integrations
                        </a>
                    </li> --}}
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Tables</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="card_information">
                            <i class="bi bi-credit-card"></i>
                            Card Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="cart">
                            <i class="bi bi-cart-check"></i>
                            Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="category">
                            <i class="bi bi-bookmark"></i>
                            Category
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="class">
                            <i class="bi bi-diagram-3"></i>
                            Class
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="class_student">
                            <i class="bi bi-people"></i>
                            Student In Class
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="comment">
                            <i class="bi bi-chat-right-text"></i>
                            Comment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="course">
                            <i class="bi bi-book"></i>
                            Course
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="favorite">
                            <i class="bi bi-heart"></i>
                            Favorite
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="promo">
                            <i class="bi bi-patch-minus"></i>
                            Promo Code
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="rating">
                            <i class="bi bi-star"></i>
                            Rating
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="receipt">
                            <i class="bi bi-receipt"></i>
                            Receipt
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="receipt_items">
                            <i class="bi bi-ui-checks"></i>
                            Receipt Items
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn nav-link" id="table" name="users">
                            <i class="bi bi-person"></i>
                            Users
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
@endisset