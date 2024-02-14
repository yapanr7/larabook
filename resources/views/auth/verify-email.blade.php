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
                                    <div class="mb-4">
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-title bg-light text-primary display-5 rounded-circle shadow">
                                                <i class="ri-mail-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-muted text-center mx-lg-3">
                                        <h4 class="">Verify Your Email</h4>
                                        <p>Masukan 4 digit kode verifikasi pada email <span class="fw-semibold">{{ auth()->user()->email }}</span></p>
                                    </div>

                                    <div class="mt-4">
                                        <form action="{{ route('verify-otp')}}" method="POST" autocomplete="off">
                                            @csrf
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="digit1-input" class="visually-hidden">Digit 1</label>
                                                        <input type="text" name="digit_1" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(1, event)" maxLength="1" id="digit1-input" required>
                                                        @error('digit_1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                </div><!-- end col -->

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="digit2-input" class="visually-hidden">Digit 2</label>
                                                        <input type="text" name="digit_2" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(2, event)" maxLength="1" id="digit2-input" required>
                                                        @error('digit_2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                </div><!-- end col -->

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="digit3-input" class="visually-hidden">Digit 3</label>
                                                        <input type="text" name="digit_3" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(3, event)" maxLength="1" id="digit3-input" required>
                                                        @error('digit_3')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                </div><!-- end col -->

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="digit4-input" class="visually-hidden">Digit 4</label>
                                                        <input type="text" name="digit_4" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(4, event)" maxLength="1" id="digit4-input" required>
                                                        @error('digit_4')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                </div><!-- end col -->
                                            </div>

                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-success w-100">Confirm</button>
                                            </div>

                                        </form>

                                    </div>

                                    <div class="mt-5 text-center">
                                        <p class="mb-0">Tidak menerima kode OTP?
                                                <a href="{{ route('resend-otp')}}" class="btn btn-link fw-semibold text-primary text-decoration-underline p-0">Kirim ulang</a>
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

    <script>
        function moveToNext(currentDigit, event) {
            var keyCode = event.keyCode || event.which;

            // Jika tombol yang ditekan adalah digit dari 0 hingga 9
            if (keyCode >= 48 && keyCode <= 57) {
                // Mendapatkan nilai digit yang dimasukkan
                var digitValue = String.fromCharCode(keyCode);

                // Jika digit yang dimasukkan adalah angka, pindahkan fokus ke input berikutnya
                if (currentDigit < 4) {
                    var nextInputId = 'digit' + (currentDigit + 1) + '-input';
                    document.getElementById(nextInputId).focus();
                }
            }
        }
    </script>

@endsection

