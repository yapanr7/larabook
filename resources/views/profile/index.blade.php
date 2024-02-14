@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:80px">
        <div class="profile-foreground ">
            <div class="profile-wid-bg">
                <img src="{{ asset('storage/background/'.$setting->app_background )}}" alt="{{ $setting->app_name }}" class="profile-wid-img">

            </div>
        </div>
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
            <div class="row g-4">

                <!--end col-->
                <div class="col">
                    <div class="p-2">
                        <h2 class="text-white fw-bold mb-1">{{ auth()->user()->name }}</h2>
                        <h5 class="text-white text-opacity-75">{{ auth()->user()->email }}</h5>

                    </div>
                </div>
            </div>
            <!--end row-->
        </div>

        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div>
                    <div class="d-flex profile-wrapper">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab"
                                    aria-selected="true">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i>
                                    <span class="d-none d-md-inline-block">Overview</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#documents" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="ri-folder-4-line d-inline-block d-md-none"></i>
                                    <span class="d-none d-md-inline-block">Documents</span>
                                </a>
                            </li>
                        </ul>
                        <div class="flex-shrink-0">
                            <a href="pages-profile-settings.html" class="btn btn-success"><i
                                    class="ri-edit-box-line align-bottom"></i> Edit
                                Profile</a>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content pt-4 text-muted">
                        <div class="tab-pane active" id="overview-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12 mx-auto">
                                    <x-latest-booking />
                                </div>

                            </div>
                            <!--end row-->
                        </div>

                        <!--end tab-pane-->
                        <div class="tab-pane fade" id="documents" role="tabpanel">
                            <x-booking-photo></x-booking-photo>
                        </div>
                        <!--end tab-pane-->
                    </div>
                    <!--end tab-content-->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
@endsection
