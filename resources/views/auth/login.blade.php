@extends('layouts.auth')

@section('content')
    <div class="bg-overlay"></div>
    <!-- auth-page content -->
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-5">
                                <div class="p-lg-5 p-4 h-100"
                                    style="background-image:url({{ asset('storage/background/'. $setting->app_background)}});background-position:center;background-size:cover">
                                    <div class="bg-overlay"></div>
                                    <div class="position-relative h-100 d-flex flex-column">
                                        <div class="mb-4">
                                            <a href="{{ url()->current() }}" class="d-block">
                                                <x-logo></x-logo>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-7">
                                <div class="p-lg-5 p-4">
                                    <div>
                                        <h5 class="text-primary">{{ $setting->app_name ?? env('app.name') }} !</h5>
                                        <p class="text-muted">Login dengan akun anda
                                            .</p>
                                    </div>

                                    <div class="mt-4">
                                        <form action="{{ route('login') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">{{ __('E-mail') }}</label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">

                                                <div class="float-end">
                                                    @if (Route::has('forget.password.get'))
                                                        <a class="btn btn-link" href="{{ route('forget.password.get') }}">
                                                            {{ __('Lupa password?') }}
                                                        </a>
                                                    @endif
                                                </div>

                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        placeholder="Enter password" name="password" id="password-input">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                                        type="button" id="password-addon"><i
                                                            class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">Sign In</button>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <p class="mb-0">Belum punya akun? ? <a href="{{ route('register') }}"
                                                class="fw-semibold text-primary text-decoration-underline"> Daftar disini</a> </p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
@endsection
