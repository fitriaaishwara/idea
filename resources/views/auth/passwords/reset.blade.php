@extends('layouts.master-without-nav')

@section('title')
@lang('translation.Recover_Password')
@endsection

@section('body')

<body>
    @endsection

    @section('content')
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="index" class="d-block auth-logo">
                                        <img src="https://ideakonsultan.com/wp-content/uploads/2021/11/idea-konsultan-tanpa-bg.png"
                                        alt="" height="28"> <span class="logo-txt">System IDEA</span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">Reset Password</h5>
                                        {{-- <p class="text-muted mt-2">Reset Password with Minia.</p> --}}
                                    </div>
                                    <form class="custom-form mt-4" method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="useremail" name="email" placeholder="Enter email"
                                                value="{{ $email ?? old('email') }}" id="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="userpassword">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" id="userpassword" placeholder="Enter password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="userpassword">Confirm Password</label>
                                            <input id="password-confirm" type="password"
                                                name="password_confirmation" class="form-control"
                                                placeholder="Enter confirm password">
                                        </div>

                                        <div class="mb-3 mt-4">
                                            <button class="btn btn-dark w-100 waves-effect waves-light" type="submit">Reset</button>
                                        </div>
                                    </form>

                                    <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">Remember It ? <a href="{{ url('login') }}" class="text-primary fw-semibold"> Sign In </a> </p>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                        document.write(new Date().getFullYear())
                                    </script> System Idea Konsultan
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <div class="col-xxl-9 col-lg-8 col-md-7">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-overlay bg-dark"></div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <!-- end bubble effect -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>

    @endsection
