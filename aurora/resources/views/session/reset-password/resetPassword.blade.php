{{-- @extends('layouts.user_type.guest')

@section('content')

<div class="page-header section-height-75">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                <div class="card card-plain mt-8">
                    <div class="card-header pb-0 text-left bg-transparent">
                        <h4 class="mb-0">Change password</h4>
                    </div>
                    <div class="card-body">
                        <form role="form" action="/reset-password" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div>
                                <label for="email">Email</label>
                                <div class="">
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                                    @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="password">New Password</label>
                                <div class="">
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                    @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="">
                                    <input id="password-confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Password-confirmation" aria-label="Password-confirmation" aria-describedby="Password-addon">
                                    @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Recover your password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                    <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection --}}


@extends('layouts.user_type.guest')

@section('content')

<div class="wrapper">
    <div class="form-box login">
        <h2>Change Password</h2>
        <form role="form" action="/reset-password" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                <input type="text" name="email" id="email" value="{{ $email ?? old('email') }}" required>
                <label for="" class="field-label">Email</label>
                @error('email')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="input-box">
                <span class="icon" id="password-field-icon"><i id="eyeIcon" class="fa-solid fa-eye-slash"></i></span>
                <input type="password" name="password" id="passwordField" required>
                <label for="" class="field-label">New Password</label>
                @error('password')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="input-box">
                <span class="icon" id="password-field-icon"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="password_confirmation" id="" required>
                <label for="" class="field-label">Confirm Password</label>
                @error('password')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            {{-- <div class="remember-forgot">
                <label for="remember" class="checkbox-label"><input type="checkbox" name="" id="remember"> Remember me</label>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div> --}}
            <button type="submit" class="login-register-btn">Reset Password</button>
            {{-- <div class="login-register">
                <p>Don't have an Account? <a href="/register" class="register-link">Register</a></p>
            </div> --}}
        </form>
    </div>
</div>

@endsection