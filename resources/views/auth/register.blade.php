@extends('layouts.auth')

@section('content')
    <div class="bg-overlay"></div>
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-5">
                                <div class="p-lg-5 p-4 h-100"
                                    style="background-image:url({{ asset('storage/background/' . $setting->app_background) }});background-position:center;background-size:cover">
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
                                        <form action="{{ route('register.store') }}" method="post">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="name">Nama</label>
                                                <input type="text" placeholder="Nama anda"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name') }}">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="email">Alamat Email</label>

                                                <input type="email" placeholder="email@gmail.com"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email') }}">
                                                @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password">Password</label>

                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password">
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password_confirmation">Confirm Password</label>

                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation">

                                            </div>
                                            <div class="form-group mb-3">
                                                <button type="submit" class="w-100 fw-bold btn btn-primary"
                                                >Daftar</button>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <p class="mb-0">Sudah punya akun? ? <a href="{{ route('login') }}"
                                                class="fw-semibold text-primary text-decoration-underline"> Login disini</a>
                                        </p>
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
@endsection
