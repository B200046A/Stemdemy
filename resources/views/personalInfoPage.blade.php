@include('header',['Title'=>"Personal Information Page"])
<nav class="col offset-1 my-5 ps-2" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
        @if (($LoggedUserInfo->userType) == 'Student')
            <a href="{{route('studentMain')}}">
        @elseif(($LoggedUserInfo->userType)=='Teacher')
            <a href="{{route('teacherMain')}}">
        @endif
        Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Personal Information</li>
    </ol>
</nav>
<div class="card border border-5 col-10 container p-sm-4 p-0" style="border-radius: 1rem;">
    <div class="row card-body gx-5 row-cols-1 px-auto">
        <div class="col-sm-12 col-12 mb-sm-0 mb-3">
            <label class="fs-3 mb-3">Personal Information</label>
            @if (session('status'))
                <h6 class="alert alert-success" id="status">{{ session('status') }}</h6>
            @endif
            @if (session('danger'))
                <h6 class="alert alert-danger" id="status">{{ session('danger') }}</h6>
            @endif
            <div class="card">
                <form class="card-body p-2 p-sm-3 row" id="form" enctype="multipart/form-data" action="{{ url('updatePersonalInfo/'.$LoggedUserInfo->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-12 col-sm-6">
                        <div class="row mb-sm-5 mb-3 px-3">
                            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
                            Username:
                            </label>
                            <div class="col-8 mx-auto"><input type="text" class="form-control w-100" id="username" name="username" value="{{$LoggedUserInfo->username}}"></div>
                            <span class="text-danger">@error('username'){{$message}} @enderror</span>
                        </div>
                        <div class="row mb-sm-5 mb-3 px-3">
                            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
                            Email:
                            </label>
                            <div class="col-8 mx-auto"><input type="text" class="form-control w-100" id="email" name="email" value="{{$LoggedUserInfo->email}}"></div>
                            <span class="text-danger">@error('email'){{$message}} @enderror</span>
                        </div>
                        <div class="row mb-sm-5 mb-3 px-3">
                            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
                            User Type:
                            </label>
                            <div class="col-8 mx-auto"><input type="text" readonly class="form-control w-100" id="userType" name="userType" value="{{$LoggedUserInfo->userType}}"></div>
                        </div>
                        <div class="row mb-sm-5 mb-3 px-3">
                            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
                            Joined Time:
                            </label>
                            <div class="col-8 mx-auto"><input type="text" readonly class="form-control w-100" id="joinedTime" name="joinedTime" value="<?php echo date('m/d/Y H:i:s', $LoggedUserInfo->created_at);?>"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="row mb-sm-4 mb-3 px-3">
                            <label class="form-check-label col-3 my-auto" for="flexCheckDefault">
                                Profile Pic:
                            </label>
                            <div class="col-7 my-auto">
                                <input type="file" accept="image/*" class="form-control" id="profilePic" name="profilePic">
                            </div>
                            <div class="col-2 my-auto">
                                <img src="../storage/profilePic/{{$LoggedUserInfo->profile_pic_path}}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/1946/1946429.png'" name="profileImg" id="profileImg" class="card-img-top w-100" alt="profile_pic">
                            </div>
                        </div>
                        <div class="row mb-sm-4 mb-3 px-3">
                            <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
                            Contact:
                            </label>
                            <div class="col-8 mx-auto"><input type="text" class="form-control w-100" name="contact" value="{{$LoggedUserInfo->contact_number}}"></div>
                            <span class="text-danger">@error('contact'){{$message}} @enderror</span>
                        </div>
                        <div class="row mb-sm-4 mb-3 px-3">
                            <label class="form-check-label mb-2" for="flexCheckDefault">
                                Introduction:
                            </label>
                            <div class=" mx-auto">
                                <textarea class="form-control" maxlength="150" name="description" style="height: 135px; resize:none;">{{$LoggedUserInfo->introduction}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <button type="submit" class="btn btn-primary mx-auto" style="width:120px;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('footer')