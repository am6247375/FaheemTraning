@extends('layouts.' . get_frontend_settings('theme'))
@push('title', get_phrase('Sign Up'))
@push('meta')@endpush
@push('css')
    <style>
        .form-icons .right {
            right: 20px;
            cursor: pointer !important;
        }
    </style>
@endpush
@section('content')
    <section class="login-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6">
                    <div class="login-img">
                        <img src="{{ asset('assets/frontend/' . get_frontend_settings('theme') . '/image/signup.gif') }}"
                            alt="register-banner">
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <form action="{{ route('register') }}" class="global-form login-form mt-25" id="login-form" method="post"
                        enctype="multipart/form-data">@csrf
                        <h4 class="g-title">
                            {{ $type === 'instructor' ? get_phrase('Register as Instructor') : get_phrase('Register as Student') }}
                        </h4>

                        <p class="description">{{ get_phrase('See your growth and get consulting support! ') }}</p>
                        <div class="form-group mb-5">
                            <label for="" class="form-label">{{ get_phrase('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <label for="phone" class="form-label">{{ get_phrase('Phone') }}</label>
                            <input class="form-control" id="phone" type="tel" name="phone"
                                placeholder="{{ get_phrase('Enter your phone number') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="form-group mb-5">
                            <label for="" class="form-label">{{ get_phrase('Email') }}</label>
                            <input type="email" name="email" class="form-control" placeholder="Your Email">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <label for="" class="form-label">{{ get_phrase('Password') }}</label>
                            <input type="password" name="password" class="form-control" placeholder="*********">

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">


                        @if ($type == 'instructor')
                            <!-- Skills -->
                            <div class="form-group mb-4">
                                <label class="form-label">{{ get_phrase('Skills') }}</label>
                                <input type="text" name="skills" class="form-control" value="{{ old('skills') }}"
                                    placeholder="{{ get_phrase('Separate skills by comma, e.g. Math, Physics') }}">
                                @error('skills')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Photo -->
                            <div class="form-group mb-4">
                                <label class="form-label">{{ get_phrase('Profile Photo') }}</label>
                                <input type="file" name="photo" class="form-control">
                                @error('photo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- CV / Biography -->
                            <div class="form-group mb-4">
                                <label class="form-label">{{ get_phrase('Upload Your CV / Biography') }}</label>
                                <input type="file" name="biography_file" class="form-control">
                                @error('biography_file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-5">
                                <label for="description" class="form-label">{{ get_phrase('Message') }}</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>
                        @endif

                        @if (get_frontend_settings('recaptcha_status'))
                            <button class="eBtn gradient w-100 g-recaptcha"
                                data-sitekey="{{ get_frontend_settings('recaptcha_sitekey') }}"
                                data-callback='onLoginSubmit' data-action='submit'>{{ get_phrase('Sign Up') }}</button>
                        @else
                            <button type="submit" class="eBtn gradient w-100">{{ get_phrase('Sign Up') }}</button>
                        @endif

                        <p class="mt-20">{{ get_phrase('Already have account?') }}
                            <a href="{{ route('login') }}">{{ get_phrase('Sign in') }}</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        "use strict";

        $(document).ready(function() {
            $('#showpassword').on('click', function(e) {
                e.preventDefault();
                const type = $('#password').attr('type');

                if (type == 'password') {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
        });

        $(document).ready(function() {
            $('#showcpassword').on('click', function(e) {
                e.preventDefault();
                const type = $('#cpassword').attr('type');

                if (type == 'password') {
                    $('#cpassword').attr('type', 'text');
                } else {
                    $('#cpassword').attr('type', 'password');
                }
            });
        });

        function onLoginSubmit(token) {
            document.getElementById("login-form").submit();
        }
    </script>
@endpush
