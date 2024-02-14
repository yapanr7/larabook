@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <x-card-dashboard icon="ri-ticket-2-line" total="{{ $bookings_count }}" name="Total Bookings" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-card-dashboard icon="ri-money-dollar-circle-line" total="{{ $payments_paid_today_sum }}" name="Total Payments Today" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-card-dashboard icon="ri-user-line" total="{{ $users_count }}" name="Total Users" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-card-dashboard icon="mdi mdi-package-variant-closed" total="{{ $packages_count }}" name="Total Packages" />
        </div>
    </div>
@endsection
