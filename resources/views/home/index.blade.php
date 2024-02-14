@extends('layouts.app')

@section('content')

<section class="banner " >
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-12">
                <div class="row">
                    <div class="col-lg-6 col-12 copywriting">
                        <p class="story">
                            LEARN FROM EXPERT
                        </p>
                        <h1 class="header">
                            Start Your <span class="text-purple">Developer <br> Journey</span> Today
                        </h1>
                        <p class="support">
                            Our bootcamp is helping junior developers who <br> are really passionate in the programming.
                        </p>
                        <p class="cta">
                            <a href="#bookinglist" class="btn btn-master btn-primary">
                                Booking Package
                            </a>
                        </p>
                    </div>
                   
                    <div class="col-lg-6 col-12 text-center">
                        <a href="#">
                            <img src="{{ asset('storage/background/' . $setting->app_background) }}" alt="{{ $setting->app_name }}" class="img-fluid" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row brands">
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
                    OUR SUPER BENEFITS
                </p>
                <h2 class="primary-header">
                    Learn Faster & Better
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="item-benefit">
                    <img src="{{ asset('assets/images/ic_globe.png') }}" class="icon" alt="">
                    <h3 class="title">
                        Diversity
                    </h3>
                    <p class="support">
                        Learn from anyone around the <br> world and get a new skills
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="item-benefit">
                    <img src="{{ asset('assets/images/ic_globe-1.png') }}" class="icon" alt="">
                    <h3 class="title">
                        A.I Guideline
                    </h3>
                    <p class="support">
                        Lara will help you to choose <br> which path that suitable for you
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="item-benefit">
                    <img src="{{ asset('assets/images/ic_globe-2.png') }}" class="icon" alt="">
                    <h3 class="title">
                        1-1 Mentoring
                    </h3>
                    <p class="support">
                        We will ensure that you will get <br> what you really do need
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="item-benefit">
                    <img src="{{ asset('assets/images/ic_globe-3.png') }}" class="icon" alt="">
                    <h3 class="title">
                        Future Job
                    </h3>
                    <p class="support">
                        Get your dream job in your dream <br> company together with us
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
                    <div class="col-lg-3 col-12">
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
