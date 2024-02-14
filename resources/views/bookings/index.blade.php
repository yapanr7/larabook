@extends('layouts.app')

@section('content')

    <div class="container mt-80">
     <x-breadcrumb/>

        @if ($userBookings->isEmpty())
        <div class="row">
            <div class="card" style="height: 500px">
                <div class="d-flex justify-content-center">
                    <h3 class="align-middle mt-80">
                        Belum ada data booking</h3>
                </div>
            </div>
        </div>
        @else
            <div class="row">
                @foreach ($userBookings as $booking)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card ribbon-box right overflow-hidden card-animate">
                            <div class="card-body text-center p-4">

                                @php
                                    $ribbonClass = '';
                                    $iconClass = '';

                                    switch ($booking->status) {
                                        case 'pending':
                                            $ribbonClass = 'ribbon-warning';
                                            $iconClass = 'ri-time-fill';
                                            break;

                                        case 'booked':
                                            $ribbonClass = 'ribbon-success';
                                            $iconClass = 'ri-check-fill';
                                            break;

                                        case 'canceled':
                                            $ribbonClass = 'ribbon-danger';
                                            $iconClass = 'ri-close-fill';
                                            break;

                                        default:
                                            $ribbonClass = 'ribbon-info';
                                            $iconClass = 'ri-flashlight-fill';
                                    }
                                @endphp

                                <div class="ribbon {{ $ribbonClass }} ribbon-shape trending-ribbon">
                                    <i class="{{ $iconClass }} text-white align-bottom"></i>
                                    <span class="trending-ribbon-text">{{ $booking->status }}</span>
                                </div>


                                <h5 class="mb-1 mt-4">
                                    <a href="{{ route('bookings.show', $booking->code) }}"
                                        class="link-primary">{{ $booking->package->name }}</a>
                                </h5>
                                <p class="text-muted mb-4">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}</p>


                                <div class="row mt-4">
                                    <div class="col-lg-8 border-end-dashed border-end">
                                        <h5>{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</h5>
                                        <span class="text-muted">Tanggal Booking</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <h5>{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}</h5>
                                        <span class="text-muted">Waktu</span>
                                    </div>

                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('bookings.show', $booking->code) }}" class="btn btn-light w-100">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>
@endsection
