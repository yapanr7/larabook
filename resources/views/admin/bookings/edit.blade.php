@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card card-animate">
                            <div class="card-header">
                                <div class="card-title">Edit</div>

                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                        value="{{ $booking->user->name }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="code" class="form-label">Booking Code</label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        value="{{ $booking->code }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="package_id" class="form-label">Package</label>
                                    <select class="form-control" data-choices id="package_id" name="package_id" required>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}"
                                                {{ $booking->package_id == $package->id ? 'selected' : '' }}>
                                                {{ $package->name }} ({{ number_format($package->price) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="status_booking" class="form-label">Status Booking</label>
                                    <select class="form-control" data-choices id="status_booking" name="status" required>
                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="booked" {{ $booking->status === 'booked' ? 'selected' : '' }}>
                                            Booked
                                        </option>
                                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                        <option value="canceled" {{ $booking->status === 'canceled' ? 'selected' : '' }}>
                                            Canceled
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date"
                                        value="{{ $booking->date }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="time" class="form-label">Time</label>
                                    <input type="time" class="form-control" id="time" name="time"
                                        value="{{ $booking->time }}" required>
                                </div>


                            </div>
                            <div class="card-footer">

                                <button type="submit" class="btn btn-primary">Update Booking</button>
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-dark">Back</a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
