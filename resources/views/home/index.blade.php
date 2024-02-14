@extends('layouts.app')

@section('content')
    <div class="container mt-80">
        <x-hero></x-hero>
        <div class="row">
            <div class="col-lg-12">
                <div class="package-list">

                    <div class="row">
                        @if ($latestPackages->isEmpty())
                            <div class="card" style="height: 500px">
                                <div class="d-flex justify-content-center">
                                    <h3 class="align-middle mt-80">
                                        No Packages Data</h3>
                                </div>
                            </div>
                        @else
                            @foreach ($latestPackages as $package)
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="card rouded shadow-lg card-animate">
                                        <img src="{{ asset('storage/' . $package->image) }}" style="object-fit: cover;"
                                            class="card-img-top" height="250" alt="{{ $package->name }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-semibold">{{ $package->name }}</h5>
                                            <div class="row">
                                                <div class="col-md-6 col-12 border-end-dashed border-end">
                                                    <span class="text-muted fs-mobile">Harga</span>
                                                    <h6 class="fs-mobile">{{ rupiah($package->price) }}</h6>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <span class="text-muted fs-mobile">Booking</span>
                                                    <h6 class="fs-mobile">{{ rupiah($package->minimal_booking_price) }}</h6>
                                                </div>

                                            </div>
                                            <a href="{{ route('packages.show', $package->slug) }}"
                                                class="btn btn-primary bg-custom text-white w-100 fw-bold">Booking Now!</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="row mb-5">
                        <div class="hstack gap-2 justify-content-center">
                            <a href="{{ route('packages.index')}}" class="btn btn-primary fw-bold btn-label">
                                <i class="ri-arrow-right-s-line label-icon align-middle fs-16 me-2"></i> Lihat Semua
                                Packages
                            </a>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

    @guest
    <section class="section bg-light">
        <div class="container">


                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">Belum punya akun?</h3>

                            <div class="hstack gap-2 justify-content-center">
                                <a href="#" class="btn btn-primary fw-bold btn-label"><i
                                        class="ri-mail-line label-icon align-middle fs-16 me-2"></i> Register Sekarang</a>

                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </section>
    @endguest
@endsection
