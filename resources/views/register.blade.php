@include('header',['Title'=>"Stemdemy - Register"])
<section class="">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card border border-5" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mt-md-4 pb-0">
                            <h2 class="fw-bold mb-5 text-uppercase">Register</h2>

                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if(Session::get('danger'))
                                <div class="alert alert-danger">
                                    {{ Session::get('danger') }}
                                </div>
                            @endif
                            
                            <div class="container">
                                <form class="row" id="form" enctype="multipart/form-data" action="{{ route('save')}}" method="post">
                                    @csrf
                                    <div class="col-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('name') }}">
                                            <label class="ms-3" for="floatingInput">Username</label>
                                            <span class="text-danger">@error('username'){{$message}} @enderror</span>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" placeholder="name@example.com" value="{{ old('email') }}">
                                            <label class="ms-3" for="floatingInput">Email address</label>
                                            <span class="text-danger">@error('email'){{$message}} @enderror</span>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" placeholder="Password" maxlength="20">
                                            <label class="ms-3" for="floatingPassword">Password</label>
                                            <span class="text-danger">@error('password'){{$message}} @enderror</span>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="rpassword" placeholder="Re-Type Password" maxlength="20">
                                            <label class="ms-3" for="floatingPassword">Re-Type Password</label>
                                            <span class="text-danger">@error('rpassword'){{"Re-type password field is required."}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-3">
                                            <input type="file" accept="image/*" class="form-control" id="profilePic" name="profilePic">
                                            <label class="ms-3" for="formFile">Profile Pic</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="tel" id="inputTel" class="form-control" name="contact" placeholder="name@example.com" maxlength="20">
                                            <label class="ms-3" for="typePhone">Contact No</label>
                                            <span class="text-danger">@error('contact'){{$message}} @enderror</span>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" maxlength="150" name="description" placeholder="Description" style="height: 135px; resize:none;"></textarea>
                                            <label class="ms-3" for="floatingDescription">Introduction</label>
                                        </div>

                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="my-4">
                                            <label for="inputUserType" class="col-form-label" onselectstart="return false">User Type:</label>
                                            <div class="btn-group" role="group" aria-label="User Type">
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradioStudent" value="Student" autocomplete="off">
                                                <label class="btn btn-outline-primary" for="btnradioStudent">Student</label>

                                                <input type="radio" class="btn-check" name="btnradio" id="btnradioTeacher" value="Teacher" autocomplete="off">
                                                <label class="btn btn-outline-primary" for="btnradioTeacher">Teacher</label>
                                            </div>
                                            <br>
                                            <span class="text-danger">@error('btnradio'){{"Please choose one of the user types."}} @enderror</span>
                                        </div>
                                        <div class="checkbox mb-3" onselectstart="return false">
                                            <label>
                                                <input type="checkbox" id="checkboxAgree" name="agree" value="agree"> I agree to the 
                                                <a href="#!" class="text-blue-50 fw-bold">Terms of Use</a> and 
                                                <a href="#!" class="text-blue-50 fw-bold">Privacy Policy</a>
                                            </label>
                                            <br><span class="text-danger">@error('agree'){{"You have to agree with our Terms of Use and Privacy Policy before register an account."}} @enderror</span>
                                        </div>
                                        <button class="w-25 btn btn-lg btn-primary mt-3" id="btnRegister" type="submit" disabled>Register</button>
                                        <p class="mt-2">Already have an account? <a href="{{ route('login') }}" class="text-black-50 fw-bold">Sign In</a></p>
                                    </div>
                                </form>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    setInputFilter(document.getElementById("inputTel"), function(value) {
        return /^-?\d*$/.test(value); 
    });

    document.getElementById("checkboxAgree").onchange = function() {
        if(this.checked){
            document.getElementById("btnRegister").disabled=false;
        }else{
            document.getElementById("btnRegister").disabled=true;
        }
    };
</script>
@include('footer')