@include('header',['Title'=>"Stemdemy - Login"])
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card border border-5" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form class="mb-md-5 mt-md-4 pb-0" action="{{ route('check')}}" method="post">
                            @csrf
                            <h2 class="fw-bold mb-5 text-uppercase">Login</h2>
                            @if(Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}
                            </div>
                            @endif
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                                <span class="text-danger">@error('email'){{$message}} @enderror</span>
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <span class="text-danger">@error('password'){{$message}} @enderror</span>
                            </div>

                            <p class="small mb-1 pb-lg-2">
                                {{-- <a class="text-black-50" href="#!">Forgot password?</a> --}}
                            </p>

                            <button class="w-100 btn btn-lg btn-primary mb-2" type="submit">Sign in</button>

                            <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-black-50 fw-bold">Sign Up</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('footer')