@extends('layouts.app')

@section('content')

<section class="banner " >
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-12">
                <div class="row">
                    <div class="col-lg-6 col-12 copywriting">
                        <p class="story ">
                            VIP SKIN CENTER
                        </p>
                        <h1 class="header  animate__animated animate__pulse">
                            Start Your <span class="text-purple">Online <br> Booking</span> Today
                        </h1>
                        <p class="support">
                           <strong> <span class="text-purple ">VIP SKIN CENTER</span></strong> believes everyone has a unique concept of beauty, that's why we will provide personalized and focus for facial, body, and hair treatment. Our commitment to give premium skin treatment that focuses on lasting and healthy skin naturally.
                        </p>
                        <p class="cta">
                            <a href="#bookinglist" class="btn btn-master btn-primary">
                                Booking Package
                            </a>
                        </p>
                    </div>
                   
                    <div class="col-lg-6 col-12 text-center ">
                        <a href="#">
                            <img src="{{ asset('storage/background/' . $setting->app_background) }}" alt="{{ $setting->app_name }}" class="img-fluid rounded rounded-lg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row brands animate__animated animate__fadeIn">
            <div class="col-lg-12 col-12 text-center">
                <img src="{{ asset('images/brands.png') }}" alt="">
            </div>
        </div>
    </div>
</section>

<section class="benefits">
    <div class="container">
        <div class="row text-center pb-70">
            <div class="col-lg-12 col-12 header-wrap">
                <p class="story">
                    Cara Pemesanan {{ $setting->app_name }}
                </p>
                <h2 class="primary-header">
                    {{ $setting->app_tagline }}
                </h2>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-3 col-12">
                <div class="item-benefit ">
                    <img src="{{ asset('assets/images/ic_globe-2.png') }}" class="icon" alt="">
                    <h3 class="title">
                        Member Login
                    </h3>
                    <p class="support">
                       Sebelum melakukan pemesanan <br> member melakukan pendaftaran atau login akun
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="item-benefit">
                    <img src="{{ asset('assets/images/ic_globe-1.png') }}" class="icon" alt="">
                    <h3 class="title">
                       Booking
                    </h3>
                    <p class="support">
                        Member klik memilih treatment <br> lalu klik booking untuk pemesanan
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="item-benefit">
                    <img src="{{ asset('assets/images/ic_globe.png') }}" class="icon" alt="">
                    <h3 class="title">
                        Transaction
                    </h3>
                    <p class="support">
                        Member melakukan pembayaran <br> bisa dengan uang muka atau pembayaran penuh
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="item-benefit">
                    <img src="{{ asset('assets/images/ic_globe-3.png') }}" class="icon" alt="">
                    <h3 class="title">
                        Finish
                    </h3>
                    <p class="support">
                        Pemesanan berhasil. <br> 
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pricing " id="bookinglist">
    <div class="container">
        <div class="row pb-70">
            
            <div class="col-lg-12 col-12">
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
                    <div class="col-lg-3 col-12 ">
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
                    <div class="hstack gap-2 justify-content-center">
                        <p>
                            <a href="{{ route('packages.index')}}" class="btn btn-master btn-secondary w-100 mt-3">
                                Lihat Semua Packages
                            </a>
                        </p>
                       
                    </div>
                </div>
            </div>
        </div>
      
    </div>
</section>

<section class="testimonials">
    <div class="container">
       
        
    </div>
</section>

@endsection
