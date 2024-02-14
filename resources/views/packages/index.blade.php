@extends('layouts.app')

@section('content')
    <div class="container mt-80">
        {{-- <div class="foreground ">
            <div class="top-wid-bg">
                <img src="{{ asset('storage/background/' . $setting->app_background) }}" alt="{{ $setting->app_name }}"
                    class="top-wid-img">
            </div>
        </div> --}}
        <div class="pt-4 mb-4 mb-lg-3 home-wrapper">
            <div class="row g-4">

                <!--end col-->
                <div class="col">
                    <div class="p-2">
                        <h1 class="text-purple mb-1">Packages</h1>
                        <h4 class="text-dark text-opacity-75">Pilih Package yang kamu mau</h4>

                    </div>
                </div>
            </div>
            <!--end row-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="package-list">

                    <div class="row">
                        @if ($packages->isEmpty())
                            <div class="card" style="height: 500px">
                                <div class="d-flex justify-content-center">
                                    <h3 class="align-middle mt-80">
                                        No Packages Data</h3>
                                </div>
                            </div>
                        @else
                            @foreach ($packages as $package)
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
                                            <p>
                                                <a href="{{ route('packages.show', $package->slug) }}" class="btn btn-master btn-secondary w-100 mt-3">
                                                    Booking Now!
                                                </a>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="row mb-5">
                          {{ $packages->links() }}
                    </div>

                </div>
            </div>


        </div>
    </div>

@endsection
